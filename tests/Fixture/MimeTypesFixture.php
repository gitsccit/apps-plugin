<?php

namespace Apps\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MimeTypesFixture
 */
class MimeTypesFixture extends TestFixture
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
        'name' => [
            'type' => 'string',
            'length' => 120,
            'null' => false,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'image' => [
            'type' => 'string',
            'length' => null,
            'null' => false,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'resize' => [
            'type' => 'string',
            'length' => null,
            'null' => false,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'file_id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => true,
            'default' => null,
            'comment' => 'thumbnail image',
            'precision' => null,
            'autoIncrement' => null
        ],
        'handler' => [
            'type' => 'string',
            'length' => null,
            'null' => true,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => 'special upload handler',
            'precision' => null,
            'fixed' => null
        ],
        'created_at' => [
            'type' => 'timestamp',
            'length' => null,
            'null' => false,
            'default' => 'CURRENT_TIMESTAMP',
            'comment' => '',
            'precision' => null
        ],
        'modified_at' => [
            'type' => 'timestamp',
            'length' => null,
            'null' => false,
            'default' => 'CURRENT_TIMESTAMP',
            'comment' => '',
            'precision' => null
        ],
        '_indexes' => [
            'FK_mime_types_files' => ['type' => 'index', 'columns' => ['file_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_mime_types_files' => [
                'type' => 'foreign',
                'columns' => ['file_id'],
                'references' => ['files', 'id'],
                'update' => 'noAction',
                'delete' => 'noAction',
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
                'name' => 'Lorem ipsum dolor sit amet',
                'image' => 'Lorem ipsum dolor sit amet',
                'resize' => 'Lorem ipsum dolor sit amet',
                'file_id' => 1,
                'handler' => 'Lorem ipsum dolor sit amet',
                'created_at' => 1567130603,
                'modified_at' => 1567130603
            ],
        ];
        parent::init();
    }
}
