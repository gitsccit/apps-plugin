<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\StoreIpMapsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\StoreIpMapsTable Test Case
 */
class StoreIpMapsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\StoreIpMapsTable
     */
    public $StoreIpMaps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.StoreIpMaps',
        'app.Stores',
        'app.Environments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StoreIpMaps') ? [] : ['className' => StoreIpMapsTable::class];
        $this->StoreIpMaps = TableRegistry::getTableLocator()->get('StoreIpMaps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StoreIpMaps);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
