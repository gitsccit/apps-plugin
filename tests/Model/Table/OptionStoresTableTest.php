<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\OptionStoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\OptionStoresTable Test Case
 */
class OptionStoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\OptionStoresTable
     */
    public $OptionStores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.OptionStores',
        'app.Options',
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
        $config = TableRegistry::getTableLocator()->exists('OptionStores') ? [] : ['className' => OptionStoresTable::class];
        $this->OptionStores = TableRegistry::getTableLocator()->get('OptionStores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OptionStores);

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
