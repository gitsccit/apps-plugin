<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\StoreDivisionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\StoreDivisionsTable Test Case
 */
class StoreDivisionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\StoreDivisionsTable
     */
    public $StoreDivisions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.StoreDivisions',
        'app.Stores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StoreDivisions') ? [] : ['className' => StoreDivisionsTable::class];
        $this->StoreDivisions = TableRegistry::getTableLocator()->get('StoreDivisions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StoreDivisions);

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
