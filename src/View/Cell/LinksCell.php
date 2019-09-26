<?php

namespace Apps\View\Cell;

use Cake\View\Cell;

/**
 * Links cell
 */
class LinksCell extends Cell
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
        $this->loadModel('AppLinks');
        $this->loadModel('Users');
    }

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($id)
    {
        $links = $this->AppLinks->getLinks($id);
        $this->set('links', $links);
    }
}
