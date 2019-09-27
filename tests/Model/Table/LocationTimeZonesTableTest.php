<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\LocationTimeZonesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\LocationTimeZonesTable Test Case
 */
class LocationTimeZonesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\LocationTimeZonesTable
     */
    public $LocationTimeZones;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.LocationTimeZones',
        'app.TimeZones'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Apps.LocationTimeZones') ? [] : ['className' => LocationTimeZonesTable::class];
        $this->LocationTimeZones = TableRegistry::getTableLocator()->get('Apps.LocationTimeZones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LocationTimeZones);

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
