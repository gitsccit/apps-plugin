<?php

namespace Apps\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OptionStoresFixture
 */
class OptionStoresFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => false,
            'default' => null,
            'comment' => '',
            'autoIncrement' => true,
            'precision' => null
        ],
        'option_id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'store_id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'environment_id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'value' => [
            'type' => 'string',
            'length' => 120,
            'null' => false,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'timestamp' => [
            'type' => 'timestamp',
            'length' => null,
            'null' => true,
            'default' => 'CURRENT_TIMESTAMP',
            'comment' => '',
            'precision' => null
        ],
        '_indexes' => [
            'FK_option_stores_stores' => ['type' => 'index', 'columns' => ['store_id'], 'length' => []],
            'FK_option_stores_options' => ['type' => 'index', 'columns' => ['option_id'], 'length' => []],
            'FK_option_stores_environments' => ['type' => 'index', 'columns' => ['environment_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_option_stores_environments' => [
                'type' => 'foreign',
                'columns' => ['environment_id'],
                'references' => ['environments', 'id'],
                'update' => 'noAction',
                'delete' => 'cascade',
                'length' => []
            ],
            'FK_option_stores_options' => [
                'type' => 'foreign',
                'columns' => ['option_id'],
                'references' => ['options', 'id'],
                'update' => 'noAction',
                'delete' => 'cascade',
                'length' => []
            ],
            'FK_option_stores_stores' => [
                'type' => 'foreign',
                'columns' => ['store_id'],
                'references' => ['stores', 'id'],
                'update' => 'noAction',
                'delete' => 'cascade',
                'length' => []
            ],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'option_id' => 1,
                'store_id' => 1,
                'environment_id' => 1,
                'value' => 'Lorem ipsum dolor sit amet',
                'timestamp' => 1563387252
            ],
        ];
        parent::init();
    }
}
