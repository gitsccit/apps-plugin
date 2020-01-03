<?php
declare(strict_types=1);

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
    protected $MimeTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Apps.MimeTypes',
        'plugin.Apps.Thumbnail',
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
        $config = TableRegistry::getTableLocator()->exists('Apps.MimeTypes') ? [] : ['className' => MimeTypesTable::class];
        $this->MimeTypes = TableRegistry::getTableLocator()->get('Apps.MimeTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MimeTypes);

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

    /**
     * Test getEnumOptions method
     *
     * @return void
     */
    public function testGetEnumOptions(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
