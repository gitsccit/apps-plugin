<?php
declare(strict_types=1);

namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\FilesStoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\FilesStoresTable Test Case
 */
class FilesStoresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\FilesStoresTable
     */
    protected $FilesStores;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Apps.FilesStores',
        'plugin.Apps.Files',
        'plugin.Apps.Stores',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FilesStores') ? [] : ['className' => FilesStoresTable::class];
        $this->FilesStores = TableRegistry::getTableLocator()->get('FilesStores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->FilesStores);

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
