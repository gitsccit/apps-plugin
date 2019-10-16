<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\AppsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\AppsTable Test Case
 */
class AppsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\AppsTable
     */
    public $Apps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Apps.Apps',
        'plugin.Apps.AppLinks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Apps.Apps') ? [] : ['className' => AppsTable::class];
        $this->Apps = TableRegistry::getTableLocator()->get('Apps.Apps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Apps);

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
}
