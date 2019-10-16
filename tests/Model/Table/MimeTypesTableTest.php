<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\MimeTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\MimeTypesTable Test Case
 */
class MimeTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\MimeTypesTable
     */
    public $MimeTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Apps.MimeTypes',
        'plugin.Apps.Files'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Apps.MimeTypes') ? [] : ['className' => MimeTypesTable::class];
        $this->MimeTypes = TableRegistry::getTableLocator()->get('Apps.MimeTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MimeTypes);

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
