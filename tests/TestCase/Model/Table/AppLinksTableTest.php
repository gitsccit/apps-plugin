<?php
declare(strict_types=1);

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
    protected $AppLinks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Apps.AppLinks',
        'plugin.Apps.Apps',
        'plugin.Apps.Permissions',
        'plugin.Apps.Files',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
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
    public function tearDown(): void
    {
        unset($this->AppLinks);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getLinks method
     *
     * @return void
     */
    public function testGetLinks(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getChildLinks method
     *
     * @return void
     */
    public function testGetChildLinks(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
