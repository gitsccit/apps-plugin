<?php

namespace Apps\View\Cell;

use Cake\View\Cell;

/**
 * CurrentNav cell
 * @property \Apps\Model\Table\Apps $Apps
 */
class AppNavCell extends Cell
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

        $this->loadModel('Apps');
        //$this->loadModel('AppLinks');
    }

    public function active($sequence)
    {

        // get the name of the current active plugin
        $plugin = $this->request->getParam('plugin');

        $app = $this->Apps->find('all', [
            'conditions' => ['Apps.cake_plugin =' => (string)$plugin],
            'contain' => ['AppLinks' => ['ChildLinks','Permissions','Files']],
            'order' => ['sort' => 'ASC', 'name' => 'ASC'],
        ])->first();

        $this->set([
            'sequence' => $sequence,
            'title' => $app->name,
            'plugin' => (empty($app->cake_plugin) ? null : $app->cake_plugin),
            'links' => $app->app_links,
        ]);

    }

    public function history($sequence,$history)
    {

        $this->set([
            'sequence' => $sequence,
            'links' => $history,
        ]);

    }

    public function apps($sequence)
    {

        $apps = $this->Apps->find('all')->all();
        $this->set([
            'sequence' => $sequence,
            'links' => $apps,
        ]);

    }

}
