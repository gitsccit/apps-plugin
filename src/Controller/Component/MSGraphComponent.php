<?php
declare(strict_types=1);

/*
 * Active directory and onedrive access using Microsoft's Graph API
 *
 * Uses the azure app "SCC Intranet for service account"
 * https://portal.azure.com/#blade/Microsoft_AAD_RegisteredApps/ApplicationMenuBlade/Overview/appId/cbff62d7-965e-4abe-b6bf-f1b489f30035/objectId/6340e59f-c7ab-4387-a8a1-c778ccb0122c/isMSAApp/
 *
 * function addFile(path,filename,content) uploads a file to onedrive. path is the folder, filename is the name, content is the string body of the file OR a path to a file on the local drive
 * function getFolder(path) lists the children of a folder in onedrive
 * function getFile(id) fetches the content of a file from onedrive by ID
 * function deleteFile(id) removes a file from onedrive by ID. this function also recursively removes empty folders
 *
 * these functions will sync the active directory to our users and users_contacts tables
 * function updateUsersDelta() looks for changes and updates only users that have changed since the last call of updateUsersDelta
 * function updateUsers() updates/syncs ALL users. note that this can take longer than 30 seconds
 */

namespace Apps\Controller\Component;

use Cake\Cache\Cache;
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Client;
use Cake\Http\Exception\NotAcceptableException;
use Cake\Http\Exception\ServiceUnavailableException;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Validation\Validation;

class MSGraphComponent extends Component
{
    /**
     * Reference to the current controller.
     *
     * @var \Cake\Controller\Controller
     */
    protected $controller;
    protected $oauthForwarding;
    private $config;
    private $timezones;
    private $userFields = [
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
        "otherMails",
        "proxyAddresses",
        "userType",
        "isResourceAccount",
    ];

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->config = array_merge(Configure::readOrFail('MSGraph.Common'), Configure::readOrFail('MSGraph.Service'));
        $this->timezones = false;
        $this->controller = $this->_registry->getController();
        $this->oauthForwarding = is_dir($_SERVER['DOCUMENT_ROOT'] . '/oauthfwd');

        // clear tokens for permissions testing
        if (false) {
            Cache::delete('MSGraphAccessToken', 'MSGraph');
            Cache::delete('MSGraphRefreshToken', 'forever');
        }

        // look for a token
        $this->accessToken = Cache::read('MSGraphAccessToken', 'MSGraph');
        if ($this->accessToken === false) {
            // no token; look for a refresh token
            $this->refreshToken = Cache::read('MSGraphRefreshToken', 'forever');
            if ($this->refreshToken === false) {
                // no accessToken, no refreshToken; warn to get a fresh authorization code
                $host = empty($_SERVER['HTTP_HOST']) ? "" : $_SERVER['HTTP_HOST'];
                $this->controller->Flash->error("MSGraph service account is not logged in. An administrator must log in <a href=\"https://" . $host . Router::url([
                        'controller' => "Session",
                        'action' => "msgraphauthcode",
                        'plugin' => 'Apps',
                    ]) . "\">here</a> using the webmsgraph user.", ['escape' => false]);
            } else {
                // use the refresh token to get a fresh access token
                $this->accessToken($this->refreshToken, true);
            }
        }

        // 5% chance to sync the user list
        if (rand(1, 100) > 95) {
            set_time_limit(300);
            $this->updateUsersDelta();
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

        $response = $http->post(
            $this->config['auth_url'] . rawurlencode($this->config['tenant']) . "/oauth2/v2.0/token",
            [
                'client_id' => $this->config['application_id'],
                'scope' => $this->config['scope'],
                $type => $code,
                'redirect_uri' => $redirect,
                'grant_type' => ($refresh ? "refresh_token" : "authorization_code"),
                'client_secret' => $this->config['client_secret'],
            ]
        );

        $json = $response->getJson();
        if (empty($json['access_token']) || empty($json['refresh_token'])) {
            throw new ServiceUnavailableException(__('response tokens were incomplete' . print_r($json, true)));
        }

        $this->accessToken = $json['access_token'];

        // verify that this is the webmsgraph user
        $user = $this->getMe();
        if ($user['accountEnabled'] && array_search($this->config['service_username'], $user, true) !== false) {
            Cache::write('MSGraphAccessToken', $json['access_token'], 'MSGraph');
            Cache::write('MSGraphRefreshToken', $json['refresh_token'], 'forever');
        } else {
            $this->accessToken = false;
            Cache::delete('MSGraphAccessToken', 'MSGraph');
            Cache::delete('MSGraphRefreshToken', 'forever');
            throw new ServiceUnavailableException("MSGraph must be logged in as the webmsgraph user");
        }
    }

    public function getMe()
    {

        $fields = ["accountEnabled", "displayName", "mailNickname"];
        $json = $this->get("me?\$select=" . implode(",", $fields));

        return $json;
    }

    private function get($path, $json = true)
    {
        if (substr($path, 0, 4) == "http") {
            $url = $path;
        } else {
            $url = $this->config['api_url'] . $path;
        }

        $http = new Client(['headers' => ['Authorization' => "Bearer " . $this->accessToken]]);
        $response = $http->get($url);

        $j = $response->getJson();
        if (!empty($j['error']['message'])) {
            if (array_search($j['error']['code'], ['itemNotFound']) !== false) {
                return false;
            }

            throw new ServiceUnavailableException(__($j['error']['code'] . " : " . $j['error']['message']));
        }

        if ($json) {
            return $j;
        } else {
            $headers = $response->getHeaders();
            $file = [
                'mimetype' => $headers['Content-Type'][0],
                'content' => (empty($headers['Location'][0]) ? $response->getStringBody() : file_get_contents($headers['Location'][0])),
            ];

            return $file;
        }
    }

    public function updateUsersDelta()
    {
        $url = Cache::read('MSGraphUserDeltaLink', 'forever');
        if ($url === false) {
            $url = "/users/delta?\$select=id";
        }

        $users = [];
        $json = $this->get($url);
        while (!empty($json['@odata.nextLink'])) {
            $temp = $this->get($json['@odata.nextLink']);
            $temp['value'] = array_merge($json['value'], $temp['value']);
            $json = $temp;
        }
        foreach ($json['value'] as $user) {
            $users[] = $user['id'];
        }

        if (!empty($json['@odata.deltaLink'])) {
            Cache::write('MSGraphUserDeltaLink', $json['@odata.deltaLink'], 'forever');
        }

        return $this->updateUsers($users);
    }

    public function updateUsers($filter = false)
    {
        if (is_array($filter) && sizeof($filter) == 0) {
            return 0;
        }

        $json = $this->get("/users?\$select=" . implode(",", $this->userFields));
        while (!empty($json['@odata.nextLink'])) {
            $temp = $this->get($json['@odata.nextLink']);
            $temp['value'] = array_merge($json['value'], $temp['value']);
            $json = $temp;
        }

        foreach ($json['value'] as $key => $value) {
            $json['value'][$key]['match'] = [];
        }

        // walk through the user list and attempt to combine entries
        foreach ($json['value'] as $key => $user) {
            foreach ($json['value'] as $k => $compare) {
                if (
                    $compare['id'] != $user['id'] && array_search(
                        $user['id'],
                        $json['value'][$k]['match']
                    ) === false && $this->userCompare(
                        $json['value'][$key],
                        $json['value'][$k]
                    )
                ) {
                    $this->userCombine($json['value'][$key], $json['value'][$k]);
                }
            }
        }

        if ($filter) {
            foreach ($json['value'] as $key => $value) {
                if (sizeof($value['match']) && array_search($value['id'], $filter) !== false) {
                    $filter = array_unique(array_merge($filter, $value['match']));
                }
            }
        }

        $count = 0;
        foreach ($json['value'] as $user) {
            if ($filter === false || array_search($user['id'], $filter) !== false) {
                if ($this->updateUser($user)) {
                    $count++;
                }
            }
        }

        return $count;
    }

    private function userCompare($a, $b)
    {
        if (
            $this->stringCompare($a['mailNickname'], $b['mailNickname'])
            || $this->stringCompare($a['displayName'], $b['displayName'])
            || ($this->stringCompare($a['givenName'], $b['givenName']) && $this->stringCompare(
                $a['surname'],
                $b['surname']
            ))
        ) {
            return true;
        }

        return false;
    }

    private function stringCompare($a, $b)
    {
        // place in an array; shortest string in position 0
        $compare = [$b, $a];
        if (strlen($a) < strlen($b)) {
            $compare = array_reverse($compare);
        }

        // only compare a-z (ignore numbers, spaces, special chars)
        foreach ($compare as $k => $v) {
            $compare[$k] = preg_replace('/[^a-z]+/', '', strtolower($v));
        }

        // true if at least 3 char and the beginning of the strings match
        if (strlen($compare[0]) >= 3 && substr($compare[1], 0, strlen($compare[0])) == $compare[0]) {
            return true;
        }

        return false;
    }

    private function userCombine(&$a, &$b)
    {
        $a['match'][] = $b['id'];
        $b['match'][] = $a['id'];
        foreach ($a as $k => $v) {
            if ($k != "match" && is_array($v)) {
                $a[$k] = array_unique(array_merge($v, $b[$k]));
                $b[$k] = $a[$k];
            }
        }
    }

    private function updateUser($msgraph_user)
    {
        if (
            empty($msgraph_user['mailNickname'])
            || empty($msgraph_user['displayName'])
            || empty($msgraph_user['givenName'])
        ) {
            return false;
        }

        $users = TableRegistry::getTableLocator()->get('Apps.Users');

        $query = $users->find('all')->where(['ldapid' => $msgraph_user['id']]);
        $user = $query->first();

        // insert a new user if not found
        if (is_null($user)) {
            $user = $users->newEmptyEntity();
            $user->username = "";
            $user->display_name = "";
            $user->first_name = "";
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
        $locationChange = false;
        foreach ($maps as $k => $v) {
            if ($k == 'location' && $user->$k != $msgraph_user[$v]) {
                $locationChange = true;
            }
            $user->$k = $msgraph_user[$v];
        }
        $user->active = ($msgraph_user['accountEnabled'] ? "yes" : "no");

        // attempt to determine the time_zone using the location
        if (true || $locationChange) {
            $conn = ConnectionManager::get('apps_replica');
            $stmt = $conn->prepare("SELECT t.id
FROM location_time_zones l 
INNER JOIN time_zones t ON t.id = l.time_zone_id 
WHERE l.location LIKE ?
ORDER BY LENGTH(l.location) ASC
LIMIT 1", [$user->location . "%"]);
            if ($stmt->rowCount()) {
                $line = $stmt->fetch('assoc');
                $user->time_zone_id = $line['id'];
            }
        }

        // load the user's manager
        try {
            $json = $this->get("users/" . $user['ldapid'] . "/manager?\$select=id");
            if (!empty($json['id'])) {
                $query = $users->find('all')->where(['ldapid' => $json['id']]);
                $manager = $query->first();
                if (!empty($manager->id)) {
                    $user->manager_id = $manager->id;
                }
            }
        } catch (ServiceUnavailableException $e) {
            $user->manager_id = null;
        }

        $users->save($user);

        // build user email list
        $emails = [];
        if (!empty($msgraph_user['mail']) && Validation::email($msgraph_user['mail'])) {
            $emails[] = $msgraph_user['mail'];
        }
        if (sizeof($msgraph_user['proxyAddresses'])) {
            foreach ($msgraph_user['proxyAddresses'] as $email) {
                if (strtolower(substr($email, 0, 5)) == "smtp:") {
                    $e = substr($email, 5);
                    if (Validation::email($e) && stripos($e, "microsoft.com") === false) {
                        $emails[] = $e;
                    }
                }
            }
        }
        if (sizeof($msgraph_user['otherMails'])) {
            foreach ($msgraph_user['otherMails'] as $e) {
                if (Validation::email($e) && stripos($e, "microsoft.com") === false) {
                    $emails[] = $e;
                }
            }
        }
        $emails = array_unique($emails);
        sort($emails);

        // build user phone number list
        $direct = [];
        if (sizeof($msgraph_user['businessPhones'])) {
            foreach ($msgraph_user['businessPhones'] as $phone) {
                $phone = preg_replace('/[^0-9]+/', '', $phone);
                if (substr($phone, 0, 1) == "0" || substr($phone, 0, 1) == "1") {
                    $phone = substr($phone, 1);
                }
                $direct[] = $phone;
            }
        }
        $direct = array_unique($direct);
        sort($direct);

        // derive extensions from the phone numbers
        // 781-688 numbers are 4 plus the last 3 digits
        // 781-742 numbers are the last 4 digits
        $ext = [];
        if (sizeof($direct)) {
            foreach ($direct as $p) {
                if (substr($p, 0, 6) == "781688") {
                    $ext[] = "4" . substr($p, 7, 3);
                } else {
                    if (substr($p, 0, 6) == "781742") {
                        $ext[] = substr($p, 6, 4);
                    } else {
                        if (strlen($p) > 10) {
                            $ext[] = substr($p, 10);
                        }
                    }
                }
            }
        }

        // get mobile number
        $mobile = [];
        if (!empty($msgraph_user['mobilePhone'])) {
            $m = preg_replace('/[^0-9]+/', '', $msgraph_user['mobilePhone']);
            if (substr($m, 0, 1) == "0" || substr($m, 0, 1) == "1") {
                $m = substr($m, 1);
            }
            $mobile[] = $m;
        }

        $user_contacts = [];
        foreach ($emails as $v) {
            $user_contacts[] = ['Email', $v];
        }
        foreach ($direct as $v) {
            $user_contacts[] = ['Direct', $v];
        }
        foreach ($ext as $v) {
            $user_contacts[] = ['Ext', $v];
        }
        foreach ($mobile as $v) {
            $user_contacts[] = ['Mobile', $v];
        }

        $contacts = TableRegistry::getTableLocator()->get('Apps.UserContacts');

        $query = $contacts->find('all')->where(['user_id' => $user['id']]);
        foreach ($query as $item) {
            $found = false;
            foreach ($user_contacts as $k => $c) {
                if ($c[0] == $item->type && $c[1] == $item->contact) {
                    $found = true;
                    unset($user_contacts[$k]);
                }
            }
            if ($found === false) {
                $contacts->delete($item);
            }
        }

        foreach ($user_contacts as $c) {
            $contact = $contacts->newEmptyEntity();
            $contact->user_id = $user['id'];
            $contact->type = $c[0];
            $contact->contact = $c[1];
            $contacts->save($contact);
        }

        return true;
    }

    public function authorizationCode()
    {
        $state = uniqid();
        Cache::write('MSGraphState', $state, 'MSGraph');
        Cache::write('MSGraphRedirect', $this->controller->referer(), 'MSGraph');

        $host = $this->controller->getRequest()->getEnv('HTTP_HOST'); // Configure::read("store.hostname");
        $redirect = "https://" . $host . Router::url($this->config['redirect_uri']);
        if ($this->oauthForwarding) {
            $conn = ConnectionManager::get('default');
            $conn->execute(
                "INSERT INTO oauth_proxy.oauth2_forwarding (state,forward) VALUES (?,?)",
                [$state, $redirect]
            );
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

        return $this->controller->redirect($url . "?" . http_build_query($vars));
    }

    public function authorizationCodeResponse()
    {
        // step 1 verify that this is the correct component for this oauth2 response
        $state_orig = Cache::read('MSGraphState', 'MSGraph');
        $state = $this->controller->getRequest()->getQuery('state');
        $code = $this->controller->getRequest()->getQuery('code');

        if (empty($code) || $state_orig === false || $state_orig !== $state) {
            return false;
        } // does not match this component

        // success! use the authorization code to request a new token
        $this->accessToken($code);

        $redirect = Cache::read('MSGraphRedirect', 'MSGraph');
        Cache::delete('MSGraphState', 'MSGraph');
        Cache::delete('MSGraphRedirect', 'MSGraph');
        if ($redirect) {
            return $this->controller->redirect($redirect);
        }

        return false;
    }

    public function getDrive($path = "")
    {
        if (!empty($path)) {
            $path = "/" . trim($path, "/");
        }
        $response = $this->get("/me/drive/root/children" . $path);

        //$driveid = $json['id'];
        //$json = $this->get("me/drive/special/approot/children");

        return $response;
    }

    public function addFile($folder = "", $filename, $content)
    {
        if (empty($filename)) {
            throw new NotAcceptableException("filename can not be empty");
        }

        if (empty($content)) {
            throw new NotAcceptableException("file content can not be empty");
        }

        if (strlen($content) < 160 && file_exists($content) && is_readable($content)) {
            $content = file_get_contents($content);
        }

        $folder = "/" . trim(strtolower($folder), "/");
        $folder = preg_replace('/\s+/', '-', $folder);
        $filename = strtolower($filename);
        $filename = preg_replace('/\s+/', '-', $filename);

        /* removed file name check and changed to rename conflict behavior
        $items = $this->getFolder($folder);
        foreach($items as $item)
            if(strtolower($item['name']) == strtolower($filename))
                throw new NotAcceptableException("file already exists");
        */

        /* Disabled direct upload so we can enforce the rename conflict behavior
    if(strlen($content) <= 1024 * 1024 * 4) { // direct upload if less than 4mb
        $json = $this->put("/me/drive/root:".$folder."/".$filename.":/content",$content);
        if(!empty($json['size'])) return $json['id'];
    }
    else {
        */
        // create an upload session
        $json = $this->post("/me/drive/root:" . $folder . "/" . $filename . ":/createUploadSession", [
            "@microsoft.graph.conflictBehavior" => "replace",
            "name" => $filename,
        ]);

        // error
        if (!empty($json['error']['code'])) {
            throw new NotAcceptableException($json['error']['code'] . " :\n" . $json['error']['message']);
        }

        // upload to the provided upload session url
        if (!empty($json['uploadUrl'])) {
            $len = strlen($content);
            $http = new Client([
                'headers' => [
                    "Authorization" => "Bearer " . $this->accessToken,
                    "Content-Length" => $len,
                    "Content-Range" => "bytes 0-" . ($len - 1) . "/" . $len,
                ],
            ]);
            $response = $http->put($json['uploadUrl'], $content);
            $json = $response->getJson();
            if (isset($json['size'])) {
                return $json['id'];
            }
        }

        /* END always use upload sessions so we can enforce the rename conflict behavior
    }
        */

        return false;
    }

    private function post($path, $post)
    {
        $path = $path ?? '';

        if (substr($path, 0, 4) == "http") {
            $url = $path;
        } else {
            $url = $this->config['api_url'] . $path;
        }

        $http = new Client(['headers' => ['Authorization' => "Bearer " . $this->accessToken]]);
        $response = $http->post($url, json_encode($post), ['type' => "json"]);
        $json = $response->getJson();
        if (!empty($json['error']['message'])) {
            throw new ServiceUnavailableException(__($json['error']['code'] . " : " . $json['error']['message']));
        }

        return $json;
    }

    public function getFolder($path)
    {
        $path = trim($path, "/");
        if (!empty($path)) {
            $path = ":/" . str_replace("/", ":/", $path) . ":";
        }

        $json = $this->get("/me/drive/root" . $path . "/children");

        $items = [];
        if (isset($json['value']) && is_array($json['value'])) {
            foreach ($json['value'] as $item) {
                if (isset($item['file'])) {
                    $items[] = [
                        'id' => $item['id'],
                        'type' => "file",
                        'mimeType' => $item['file']['mimeType'],
                        'name' => $item['name'],
                        'created' => strtotime($item['createdDateTime']),
                        'modified' => strtotime($item['lastModifiedDateTime']),
                        'size' => $item['size'],
                    ];
                } else { // directory
                    $items[] = [
                        'id' => $item['id'],
                        'type' => "directory",
                        'name' => $item['name'],
                        'created' => strtotime($item['createdDateTime']),
                        'modified' => strtotime($item['lastModifiedDateTime']),
                        'size' => $item['size'],
                        'children' => $item['folder']['childCount'],
                    ];
                }
            }
        }

        return $items;
    }

    public function getProfileImage($id)
    {
        try {
            $result = $this->get("/users/" . $id . "/photo/\$value", false);
        } catch (ServiceUnavailableException $e) {
            // user has no profile picture; create a default 1x1 white image
            $image = imagecreate(1, 1);
            $color = imagecolorallocate($image, 255, 255, 255);
            imagefill($image, 0, 0, $color);
            ob_start();
            imagepng($image);
            $result = [
                'mimetype' => "image/png",
                'content' => ob_get_clean(),
            ];

            // check if this theme has a default profile image. if found use it instead
            if ($theme = Configure::read("store.layout")) {
                if ($profileimage = Configure::read($theme . ".profile-image")) {
                    $files = TableRegistry::getTableLocator()->get('Apps.Files');
                    $file = $files->get($profileimage, ['contain' => 'MimeTypes']);
                    $result = $this->getFile($file->path);
                    $result['mimetype'] = $file->mime_type->name;
                }
            }
        }

        return $result;
    }

    public function getFile($id)
    {
        $file = $this->get("/me/drive/items/" . $id . "/content", false);
        if (!empty($file['content'])) {
            return $file;
        }

        return false;
    }

    public function deleteFile($id)
    {
        if (empty($id)) {
            throw new NotAcceptableException("item ID may not be empty");
        }

        $parentid = false;
        $json = $this->get("/me/drive/items/" . $id);
        if (!empty($json['parentReference']['id'])) {
            $parentid = $json['parentReference']['id'];
        }

        if ($this->delete("/me/drive/items/" . $id)) { // success!
            if ($parentid) {
                $this->deleteEmptyFolders($parentid);
            }

            return true;
        }

        return false;
    }

    private function delete($path)
    {
        if (substr($path, 0, 4) == "http") {
            $url = $path;
        } else {
            $url = $this->config['api_url'] . $path;
        }

        $http = new Client(['headers' => ['Authorization' => "Bearer " . $this->accessToken]]);
        $response = $http->delete($url);
        if (!empty($response->getStatusCode()) && $response->getStatusCode() == 204) {
            return true;
        }

        return false;
    }

    private function deleteEmptyFolders($id)
    {
        $json = $this->get("/me/drive/items/" . $id);
        if (isset($json['folder']['childCount']) && $json['folder']['childCount'] == 0) {
            // delete it! note that deleteFile will recursively check parents and delete empty folders
            $this->deleteFile($id);
        }
    }
}
