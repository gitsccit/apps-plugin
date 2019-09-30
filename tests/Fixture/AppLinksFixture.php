<?php

namespace Apps\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AppLinksFixture
 */
class AppLinksFixture extends TestFixture
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
        'app_id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'app_link_id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'permission_id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'htmlid' => [
            'type' => 'string',
            'length' => 30,
            'null' => false,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'title' => [
            'type' => 'string',
            'length' => 30,
            'null' => false,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'destination' => [
            'type' => 'string',
            'length' => 120,
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
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'sort' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => false,
            'default' => '0',
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
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
            'FK_app_links_apps' => ['type' => 'index', 'columns' => ['app_id'], 'length' => []],
            'FK_app_links_files' => ['type' => 'index', 'columns' => ['file_id'], 'length' => []],
            'FK_app_links_permissions' => ['type' => 'index', 'columns' => ['permission_id'], 'length' => []],
            'FK_app_links_app_links' => ['type' => 'index', 'columns' => ['app_link_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_app_links_app_links' => [
                'type' => 'foreign',
                'columns' => ['app_link_id'],
                'references' => ['app_links', 'id'],
                'update' => 'noAction',
                'delete' => 'cascade',
                'length' => []
            ],
            'FK_app_links_apps' => [
                'type' => 'foreign',
                'columns' => ['app_id'],
                'references' => ['apps', 'id'],
                'update' => 'noAction',
                'delete' => 'cascade',
                'length' => []
            ],
            'FK_app_links_files' => [
                'type' => 'foreign',
                'columns' => ['file_id'],
                'references' => ['files', 'id'],
                'update' => 'noAction',
                'delete' => 'setNull',
                'length' => []
            ],
            'FK_app_links_permissions' => [
                'type' => 'foreign',
                'columns' => ['permission_id'],
                'references' => ['permissions', 'id'],
                'update' => 'noAction',
                'delete' => 'setNull',
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
                'app_id' => 1,
                'app_link_id' => 1,
                'permission_id' => 1,
                'htmlid' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'destination' => 'Lorem ipsum dolor sit amet',
                'file_id' => 1,
                'sort' => 1,
                'created_at' => 1567742026,
                'modified_at' => 1567742026
            ],
        ];
        parent::init();
    }
}
