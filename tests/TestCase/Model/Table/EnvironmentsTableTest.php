<?php
declare(strict_types=1);

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
    protected $Environments;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Apps.Environments',
        'plugin.Apps.Permissions',
        'plugin.Apps.OptionStores',
        'plugin.Apps.StoreIpMaps',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Apps.Environments') ? [] : ['className' => EnvironmentsTable::class];
        $this->Environments = TableRegistry::getTableLocator()->get('Apps.Environments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Environments);

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
     * Test defaultConnectionName method
     *
     * @return void
     */
    public function testDefaultConnectionName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
