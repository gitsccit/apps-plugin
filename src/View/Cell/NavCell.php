<?php
declare(strict_types=1);

namespace Apps\View\Cell;

use Cake\View\Cell;

/**
 * Nav cell
 */
class NavCell extends Cell
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
        $this->loadModel('Apps.Users');
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display(): void
    {
        $apps = $this->Apps->find();
        $this->set(compact('apps'));
    }
}
