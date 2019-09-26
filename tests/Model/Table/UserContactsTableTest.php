<?php
namespace Apps\Test\TestCase\Model\Table;

use Apps\Model\Table\UserContactsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Apps\Model\Table\UserContactsTable Test Case
 */
class UserContactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Apps\Model\Table\UserContactsTable
     */
    public $UserContacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserContacts',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserContacts') ? [] : ['className' => UserContactsTable::class];
        $this->UserContacts = TableRegistry::getTableLocator()->get('UserContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserContacts);

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
