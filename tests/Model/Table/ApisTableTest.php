<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\ApisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\ApisTable Test Case
 */
class ApisTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\ApisTable
     */
    public $Apis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Apis'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Apps.Apis') ? [] : ['className' => ApisTable::class];
        $this->Apis = TableRegistry::getTableLocator()->get('Apps.Apis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Apis);

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
