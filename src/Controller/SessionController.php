<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace Apps\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class SessionController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Apps.MSGraphAuth');
    }

    public function beforeFilter(EventInterface $event)
    {
        // sets the index, start, and end actions to not require login
        $this->Auth->allow(["index", "start", "end"]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        return $this->login();
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|void
     */
    public function login()
    {
        return $this->MSGraphAuth->authorizationCode();
    }

    /*
     * Admin only loginAs; logs in as the requested user
     * permissions are checked in the isAuthorized method
     */

    public function loginAs($id)
    {
        $users = TableRegistry::getTableLocator()->get('Apps.Users');
        $user = $users->get($id);

        if ($user) {
            $this->Auth->setUser($user);

            return $this->redirect(['controller' => 'users', 'action' => 'view']);
        }

        throw new NotFoundException(__("User not found"));
    }

    /*
     * Admin only kill; kills the session of the requested user
     * permissions are checked in the isAuthorized method
     * THIS ONLY WORKS IF WE'RE USING PHP SERIALIZED SESSIONS
     */

    public function kill($id)
    {
        $users = TableRegistry::getTableLocator()->get('Apps.Users');
        $user = $users->get($id);

        // build a list of session files to inspect
        $session_files = [];
        $files = scandir(session_save_path());
        foreach ($files as $file) {
            if (strlen($file) > 2) {
                $path = session_save_path() . "/" . $file;
                if (is_file($path)) {
                    $session_files[] = $path;
                }
            }
        }

        // iterate through each registered session and look for this user
        foreach ($session_files as $file) {
            $session = file_get_contents($file);
            // if this session contains both the user's id and ldapid; destroy it
            if (
                strpos($session, 's:2:"id";i:' . $user->id . ';')
                && strpos($session, 's:6:"ldapid";s:' . strlen($user->ldapid) . ':"' . $user->ldapid . '";')
            ) {
                unlink($file);
            }
        }

        $this->Flash->success(__('User sessions have been destroyed.'));

        return $this->redirect(['controller' => 'users', 'action' => 'view', $user->id]);
    }

    /**
     * Start method : redirect from microsoft; validate and log the user in
     *
     * @return \Cake\Http\Response|void
     */
    public function start()
    {
        if (isset($this->MSGraph)) {
            $fwd = $this->MSGraph->authorizationCodeResponse();
            if ($fwd) {
                return $fwd;
            }
        }

        if (isset($this->MSGraphAuth)) {
            $fwd = $this->MSGraphAuth->authorizationCodeResponse();
            if ($fwd) {
                return $fwd;
            }
        }

        throw new BadRequestException(__("response did not match available services"));
    }

    /**
     * End method : log the user out
     *
     * @return \Cake\Http\Response|void
     */
    public function end()
    {

        $session = $this->getRequest()->getSession();
        $session->destroy();
        $session->renew();
    }

    public function msgraphauthcode()
    {
        // forward to auth code URL for msgraph (intended for onedrive service account)
        return $this->MSGraph->authorizationCode();
    }

    // require intranet.admin to access the loginAs action

    public function isAuthorized($user = null)
    {
        $action = $this->getRequest()->getParam('action');
        if ($action == "loginAs") {
            return $this->Auth->user()->hasPermission('admin');
        }

        return true;
    }

    /**
     * setup current main /visible menu items for selected application in a session
     * @param string $id current application ID
     * @param string $controller redirect controller
     * @param string $plugin identify type of route
     *
     * TODO this should redirect with the home page  CC JAKE
     **/
    /*
    public function currentApplication($id = null, $controller = null)
    {
        $controller = urldecode($controller);
        $session = $this->getRequest()->getSession();
        $session->write('currentApplication', $id);
        //TODO adding a plugin will need the route to be added to the routes.php  config file
        //TODO use of forward slash(/) affected my redirect (better algorithm)
        if (empty($controller)) {
            return $this->redirect(['controller' => 'home']);
        }
        return $this->redirect(['controller' => $controller]);


    }
    */

    public function trackHistory()
    {
        return false;
    }
}
