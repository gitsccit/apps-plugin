<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\StoreSortFieldsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\StoreSortFieldsTable Test Case
 */
class StoreSortFieldsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\StoreSortFieldsTable
     */
    public $StoreSortFields;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.StoreSortFields',
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
        $config = TableRegistry::getTableLocator()->exists('StoreSortFields') ? [] : ['className' => StoreSortFieldsTable::class];
        $this->StoreSortFields = TableRegistry::getTableLocator()->get('StoreSortFields', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StoreSortFields);

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
