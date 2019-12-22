<?php
declare(strict_types=1);

/*
 * Authenticates a user using microsoft's graph API.
 * Uses the azure app "SCC Intranet Login"
 * https://portal.azure.com/#blade/Microsoft_AAD_RegisteredApps/ApplicationMenuBlade/Overview/appId/84509336-1dc6-4943-919c-4996efbcd1bf/objectId/5c8918ae-5003-4cae-b98d-defcddc70114/isMSAApp/
 *
 * function getMe() will grab the currently logged in user's active directory data. this wouldn't normally be needed as this data is duplicated in the users table and included in the session
 */

namespace Apps\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Client;
use Cake\Http\Exception\ServiceUnavailableException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class MSGraphAuthComponent extends Component
{

    /**
     * Reference to the current controller.
     *
     * @var \Cake\Controller\Controller
     */
    protected $controller;

    /**
     * @var \Cake\Http\Session
     */
    private \Cake\Http\Session $session;

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->config = array_merge(Configure::readOrFail('MSGraph.Common'), Configure::readOrFail('MSGraph.Auth'));
        $this->controller = $this->_registry->getController();
        $this->session = $this->controller->getRequest()->getSession();
        $this->oauthForwarding = is_dir($_SERVER['DOCUMENT_ROOT'] . '/oauthfwd');

        // look for a token
        $this->accessToken = $this->session->read('MSGraph.accessToken');
        if ($this->accessToken === false) {
            // no token; look for a refresh token
            $this->refreshToken = $this->session->read('MSGraph.refreshToken');
            if ($this->refreshToken !== false) {
                // use the refresh token to get a fresh access token
                $this->accessToken($this->refreshToken, true);
            }
        }
    }

    public function accessToken($code, $refresh = false)
    {

        $type = ($refresh ? "refresh_token" : "code");
        $http = new Client();

        $host = $this->controller->getRequest()->getEnv('HTTP_HOST');
        $redirect = "https://" . $host . Router::url($this->config['redirect_uri']);
        if ($this->oauthForwarding) {
            $redirect = $this->config['redirect_alt_uri'];
        }

        $response = $http->post($this->config['auth_url'] . rawurlencode($this->config['tenant']) . "/oauth2/v2.0/token",
            [
                'client_id' => $this->config['application_id'],
                'scope' => $this->config['scope_service'],
                $type => $code,
                'redirect_uri' => $redirect,
                'grant_type' => "authorization_code",
                'client_secret' => $this->config['client_secret'],
            ]);

        $json = $response->getJson();
        if (empty($json['access_token']) || empty($json['refresh_token'])) {
            throw new ServiceUnavailableException(__('response tokens were incomplete' . print_r($json, true)));
        }

        $this->accessToken = $json['access_token'];

        // verify that this is a valid user
        $msgraph_user = $this->getMe();
        if ($msgraph_user['accountEnabled'] && $msgraph_user['mailNickname'] != "webmsgraph") {
            $this->session->write('MSGraph.accessToken', $json['access_token']);
            $this->session->write('MSGraph.refreshToken', $json['refresh_token']);

            // log the user in
            $user = $this->getSyncUser($msgraph_user);
            $this->userLogins($user);
        } else {
            $this->accessToken = false;
            $this->session->delete('MSGraph.accessToken');
            $this->session->delete('MSGraph.refreshToken');
            throw new ServiceUnavailableException("User account was not enabled");
        }

    }

    public function getMe()
    {

        $fields = [
            "id",
            "accountEnabled",
            "mailNickname",
            "displayName",
            "givenName",
            "surname",
            "businessPhones",
            "city",
            "companyName",
            "department",
            "faxNumber",
            "jobTitle",
            "mail",
            "mobilePhone",
            "officeLocation",
            "proxyAddresses",
            "userType"
        ];
        $json = $this->get("me?\$select=" . implode(",", $fields));
        return $json;

    }

    private function get($path, $retry = 0)
    {

        $http = new Client(['headers' => ['Authorization' => "Bearer " . $this->accessToken]]);
        $response = $http->get($this->config['api_url'] . $path);
        if (substr($response->getHeaders()['Content-Type'][0], 0, 6) == "image/") {
            return $response->getStringBody();
        }

        $json = $response->getJson();
        if (!empty($json['error']['message'])) {
            throw new ServiceUnavailableException(__($json['error']['code'] . " : " . $json['error']['message']));
        }

        return $json;

    }

    private function getSyncUser($msgraph_user)
    {

        $users = TableRegistry::getTableLocator()->get('Apps.Users');
        $query = $users->find('all', ['contain' => 'TimeZones'])->where(['ldapid' => $msgraph_user['id']]);
        $user = $query->first();

        // insert a new user if not found
        if (is_null($user)) {
            $user = $users->newEntity();
            $user->ldapid = $msgraph_user['id'];
            $user->active = "no";
            $users->save($user);
        }

        // update user with current msgraph data
        $maps = [
            'username' => "mailNickname",
            'display_name' => "displayName",
            'first_name' => "givenName",
            'last_name' => "surname",
            'email' => "mail",
            'title' => "jobTitle",
            'department' => "department",
            'location' => "officeLocation",
        ];
        foreach ($maps as $k => $v) {
            $user->$k = $msgraph_user[$v];
        }

        $users->save($user);

        return $user;

    }

    private function userLogins($user)
    {

        $user_logins = TableRegistry::getTableLocator()->get('Apps.UserLogins');
        $user_login = $user_logins->newEntity();
        $user_login->user_id = $user['id'];
        $user_login->ip_address = $_SERVER['REMOTE_ADDR'];
        $user_login->browser = $_SERVER['HTTP_USER_AGENT'];

        $user_logins->save($user_login);

        $this->controller->Auth->setUser($user);

        // 5% chance to clean up user_logins table
        if (rand(1, 100) > 95) {
            $user_logins->deleteAll(["datediff(NOW(),timestamp) > 30"]);
        }

    }

    public function authorizationCode()
    {
        $state = uniqid();
        $this->session->write('MSGraph.state', $state);
        $referer = $this->controller->referer();
        $host = $this->controller->getRequest()->getEnv('HTTP_HOST'); // Configure::read("store.hostname");
        $this->session->write('MSGraph.redirect', $this->controller->Auth->redirectUrl());

        $redirect = "https://" . $host . Router::url($this->config['redirect_uri']);
        if ($this->oauthForwarding) {
            $conn = ConnectionManager::get('default');
            $conn->execute("INSERT INTO oauth_proxy.oauth2_forwarding (state,forward) VALUES (?,?)",
                [$state, $redirect]);
            $redirect = $this->config['redirect_alt_uri'];
        }

        $url = $this->config['auth_url'] . rawurlencode($this->config['tenant']) . "/oauth2/v2.0/authorize";
        $vars = [
            'client_id' => $this->config['application_id'],
            'response_type' => $this->config['response_type'],
            'redirect_uri' => $redirect,
            'response_mode' => $this->config['response_mode'],
            'scope' => $this->config['scope'],
            'state' => $state,
        ];

        $this->session->delete('Flash.flash'); // remove flash messages
        return $this->controller->redirect($url . "?" . http_build_query($vars));

    }

    public function authorizationCodeResponse()
    {

        // step 1 verify that this is the correct component for this oauth2 response
        $state_orig = $this->session->read('MSGraph.state');
        $state = $this->controller->getRequest()->getQuery('state');
        $code = $this->controller->getRequest()->getQuery('code');

        if (empty($code) || $state_orig === false || $state_orig !== $state) {
            return false;
        } // does not match this component

        // success! use the authorization code to request a new token
        $this->accessToken($code);

        $redirect = $this->session->read('MSGraph.redirect');
        $this->session->delete('MSGraph.state');
        $this->session->delete('MSGraph.redirect');
        if ($redirect) {
            return $this->controller->redirect($redirect);
        }
        return false;

    }

    private function post($path, $post)
    {

        $http = new Client(['headers' => ['Authorization' => "Bearer " . $this->serviceToken]]);
        $response = $http->post($this->config['api_url'] . $path, json_encode($post), ['type' => "json"]);
        var_dump($response);
        die;

    }

}
