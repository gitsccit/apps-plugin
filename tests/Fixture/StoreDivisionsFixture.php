<?php

namespace Apps\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StoreDivisionsFixture
 */
class StoreDivisionsFixture extends TestFixture
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
        'store_id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => true,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'company_code' => [
            'type' => 'string',
            'length' => 3,
            'null' => false,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'ar_division_number' => [
            'type' => 'string',
            'length' => 2,
            'null' => false,
            'default' => null,
            'collate' => 'utf8mb4_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        '_indexes' => [
            'store_id' => ['type' => 'index', 'columns' => ['store_id'], 'length' => []],
            'company_code' => ['type' => 'index', 'columns' => ['company_code', 'ar_division_number'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'store_divisions_ibfk_1' => [
                'type' => 'foreign',
                'columns' => ['store_id'],
                'references' => ['stores', 'id'],
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
                'store_id' => 1,
                'company_code' => 'L',
                'ar_division_number' => 'Lo'
            ],
        ];
        parent::init();
    }
}
