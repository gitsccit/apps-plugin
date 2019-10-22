<?php

namespace Apps\View\Cell;

use Cake\View\Cell;

/**
 * CurrentNav cell
 * @property \Apps\Model\Table\AppLinksTable $AppLinks
 * @property \Apps\Model\Table\AppsTable $Apps
 */
class CurrentNavCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadModel('Apps.Apps');
        $this->loadModel('Apps.AppLinks');
    }

    /**
     * Default display method using $appId.
     * @param string $appId application id
     * @return void
     *
     */
    public function display($appId = null)
    {
        /**
         * dwere algorithm with session management for nav
         * $apps = $this->Apps->get($appId);
         * $title = $apps->name;
         * $links = $this->AppLinks->getLinks($appId)->where(['app_link_id IS NULL']);
         * $this->set(compact('title', 'links'));
         **/
        // get the name of the current active plugin
        $name = $this->request->getParam('plugin') === 'Apps' ? 'Admin' : env('APP_NAME', basename(ROOT));
        $appId = 1; // use appId 1 as the fallback
        $app = $this->Apps->find('all', [
            'conditions' => ['name' => $name],
            'order' => ['sort' => 'ASC', 'name' => 'ASC'],
        ])->first();

        if ($app) {
            $appId = $app->id;
            $name = $app->name;
        }

        $this->set([
            'title' => $name,
            'plugin' => empty($app->cake_plugin) ? null : $app->cake_plugin,
            'links' => $this->AppLinks->getLinks($appId)->where(['app_link_id IS NULL']),
        ]);
    }

    /**
     * undefined application default menu
     **/
    public function undefined()
    {
    }
}
