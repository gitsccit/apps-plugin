<?php
declare(strict_types=1);

namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\PermissionGroupsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\PermissionGroupsTable Test Case
 */
class PermissionGroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\PermissionGroupsTable
     */
    protected $PermissionGroups;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Apps.PermissionGroups',
        'plugin.Apps.Permissions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Apps.PermissionGroups') ? [] : ['className' => PermissionGroupsTable::class];
        $this->PermissionGroups = TableRegistry::getTableLocator()->get('Apps.PermissionGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PermissionGroups);

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
     * Test defaultConnectionName method
     *
     * @return void
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
