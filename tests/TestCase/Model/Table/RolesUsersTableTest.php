<?php
declare(strict_types=1);

namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\RolesUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\RolesUsersTable Test Case
 */
class RolesUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\RolesUsersTable
     */
    protected $RolesUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Apps.RolesUsers',
        'plugin.Apps.Roles',
        'plugin.Apps.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Apps.RolesUsers') ? [] : ['className' => RolesUsersTable::class];
        $this->RolesUsers = TableRegistry::getTableLocator()->get('Apps.RolesUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->RolesUsers);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
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
