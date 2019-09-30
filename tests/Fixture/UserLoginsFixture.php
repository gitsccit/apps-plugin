<?php

namespace Apps\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserLoginsFixture
 */
class UserLoginsFixture extends TestFixture
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
        'user_id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'ip_address' => [
            'type' => 'string',
            'length' => 15,
            'null' => true,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'browser' => [
            'type' => 'string',
            'length' => 200,
            'null' => true,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'width' => [
            'type' => 'smallinteger',
            'length' => 5,
            'unsigned' => true,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null
        ],
        'height' => [
            'type' => 'smallinteger',
            'length' => 5,
            'unsigned' => true,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null
        ],
        'timestamp' => [
            'type' => 'datetime',
            'length' => null,
            'null' => true,
            'default' => 'CURRENT_TIMESTAMP',
            'comment' => '',
            'precision' => null
        ],
        '_indexes' => [
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'user_logins_ibfk_1' => [
                'type' => 'foreign',
                'columns' => ['user_id'],
                'references' => ['users', 'id'],
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
                'user_id' => 1,
                'ip_address' => 'Lorem ipsum d',
                'browser' => 'Lorem ipsum dolor sit amet',
                'width' => 1,
                'height' => 1,
                'timestamp' => '2019-07-17 18:14:49'
            ],
        ];
        parent::init();
    }
}
