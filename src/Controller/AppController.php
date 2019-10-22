<?php
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

use Cake\Event\Event;
use Cake\Http\Response;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 * @property \Apps\Controller\Component\MSGraphComponent MsGraphComponent
 */
class AppController extends \Skeleton\Controller\AppController
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Apps.ConfigureFromDatabase');

        // MSGraph Service
        $this->loadComponent('Apps.MSGraph');

        // login component using MSGraph
        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'loginAction' => [
                'controller' => 'Session',
                'action' => 'login',
                'plugin' => 'Apps',
            ],
            'logoutRedirect' => [
                'controller' => 'Session',
                'action' => 'end',
                'plugin' => 'Apps',
            ]
        ]);
    }

    /**
     * @param Event $event
     * @return Response|void|null
     *
     * save to the browsing history array
     */
    public function afterFilter(Event $event)
    {
        // only save for text/html documents
        if ($this->getResponse()->getType() != "text/html" || $this->trackHistory() === false) {
            return;
        }

        // get the history array
        $session = $this->getRequest()->getSession();
        $history = $session->read('BrowsingHistory');
        if (empty($history)) {
            $history = [];
        }
        // add this request, clean up the array, and limit in size
        array_unshift($history, $_SERVER['REQUEST_URI']);
        $history = array_slice(array_unique($history), 0, 12);
        // save array to the session
        $session->write('BrowsingHistory', $history);
    }

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        $collapsed = $this->getRequest()->getCookie('collapsed');
        $collapsed = filter_var($collapsed, FILTER_VALIDATE_BOOLEAN);

        if ($this->getRequest()->is('mobile')) {
            $collapsed = true;
        }

        $this->set(compact('collapsed'));
    }

    /**
     * @param null $user
     * @return bool
     */
    public function isAuthorized($user = null)
    {
        $plugin = $this->getPlugin() === 'Apps' ? 'Admin' : env('APP_NAME', basename(ROOT));
        $controller = $this->getName();
        $action = $this->getRequest()->getParam('action');

        return $user->hasPermission("$plugin.$controller.$action");
    }

    public function trackHistory()
    {
        return true;
    }
}
