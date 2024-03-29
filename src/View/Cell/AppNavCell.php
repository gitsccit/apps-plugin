<?php
declare(strict_types=1);

namespace Apps\View\Cell;

use Cake\View\Cell;

/**
 * CurrentNav cell
 * @property \Apps\Model\Table\AppsTable $Apps
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
    public function initialize(): void
    {
        $this->loadModel('Apps.Apps');
    }

    public function active($sequence): void
    {
        // get the name of the current active plugin
        $name = $this->request->getParam('plugin') === 'Apps' ? 'Admin' : env('APP_NAME', basename(ROOT));

        $app = $this->Apps->find('all', [
            'conditions' => ['Apps.name' => $name],
            'contain' => ['AppLinks' => ['ChildLinks', 'Permissions', 'Files']],
            'order' => ['sort' => 'ASC', 'name' => 'ASC'],
        ])->first();

        $this->set([
            'sequence' => $sequence,
            'title' => $app->name,
            'plugin' => $app ? $app->cake_plugin : null,
            'links' => $app->app_links,
        ]);
    }

    public function history($sequence, $history): void
    {
        $this->set([
            'sequence' => $sequence,
            'links' => $history,
        ]);
    }

    public function apps($sequence): void
    {
        $apps = $this->Apps->find('all')->all();
        $this->set([
            'sequence' => $sequence,
            'links' => $apps,
        ]);
    }
}
