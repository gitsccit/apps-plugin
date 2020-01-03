<?php
declare(strict_types=1);

namespace Apps\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StoreIpMapsFixture
 */
class StoreIpMapsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'store_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'environment_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ip_address' => ['type' => 'string', 'length' => 39, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'port' => ['type' => 'smallinteger', 'length' => 5, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'store_id' => ['type' => 'index', 'columns' => ['store_id'], 'length' => []],
            'ip_address' => ['type' => 'index', 'columns' => ['ip_address', 'port'], 'length' => []],
            'FK_store_ip_maps_environments' => ['type' => 'index', 'columns' => ['environment_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_store_ip_maps_environments' => ['type' => 'foreign', 'columns' => ['environment_id'], 'references' => ['environments', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'store_ip_maps_ibfk_1' => ['type' => 'foreign', 'columns' => ['store_id'], 'references' => ['stores', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'store_id' => 1,
                'environment_id' => 1,
                'ip_address' => 'Lorem ipsum dolor sit amet',
                'port' => 1,
            ],
        ];
        parent::init();
    }
}
