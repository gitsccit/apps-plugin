<?php
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
    public function initialize()
    {
        $this->loadModel('Apps');
        $this->loadModel('Users');
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display()
    {
        $apps = $this->Apps->find('all');
     // var_dump($apps);
        $this->set('apps', $apps);
    }
}
