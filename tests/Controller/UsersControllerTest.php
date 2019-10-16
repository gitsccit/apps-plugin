<?php
namespace Apps\Test\TestCase\Controller;

use Apps\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Apps\Controller\UsersController Test Case
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.Apps.Users',
        'plugin.Apps.TimeZones',
        'plugin.Apps.Files',
        'plugin.Apps.UserContacts',
        'plugin.Apps.UserLogins',
        'plugin.Apps.Roles',
        'plugin.Apps.RolesUsers'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
