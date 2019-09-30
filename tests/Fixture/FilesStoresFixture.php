<?php

namespace Apps\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilesStoresFixture
 */
class FilesStoresFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'file_id' => [
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
        '_indexes' => [
            'FK_files_stores_file_id' => ['type' => 'index', 'columns' => ['file_id'], 'length' => []],
            'FK_files_stores_store_id' => ['type' => 'index', 'columns' => ['store_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['file_id', 'store_id'], 'length' => []],
            'FK_files_stores_file_id' => [
                'type' => 'foreign',
                'columns' => ['file_id'],
                'references' => ['files', 'id'],
                'update' => 'cascade',
                'delete' => 'cascade',
                'length' => []
            ],
            'FK_files_stores_store_id' => [
                'type' => 'foreign',
                'columns' => ['store_id'],
                'references' => ['stores', 'id'],
                'update' => 'cascade',
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
                'file_id' => 1,
                'store_id' => 1
            ],
        ];
        parent::init();
    }
}
