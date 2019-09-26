<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\EnvironmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\EnvironmentsTable Test Case
 */
class EnvironmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\EnvironmentsTable
     */
    public $Environments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Environments',
        'app.Permissions',
        'app.OptionStores',
        'app.StoreIpMaps'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Environments') ? [] : ['className' => EnvironmentsTable::class];
        $this->Environments = TableRegistry::getTableLocator()->get('Environments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Environments);

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
