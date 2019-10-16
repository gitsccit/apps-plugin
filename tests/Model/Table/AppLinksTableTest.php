<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\AppLinksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\AppLinksTable Test Case
 */
class AppLinksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\AppLinksTable
     */
    public $AppLinks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Apps.AppLinks',
        'plugin.Apps.Apps',
        'plugin.Apps.Permissions',
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
        $config = TableRegistry::getTableLocator()->exists('Apps.AppLinks') ? [] : ['className' => AppLinksTable::class];
        $this->AppLinks = TableRegistry::getTableLocator()->get('Apps.AppLinks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AppLinks);

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
