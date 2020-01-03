<?php
declare(strict_types=1);

namespace Apps\Test\TestCase\Controller;

use Apps\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Apps\Controller\UsersController Test Case
 *
 * @uses \Apps\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Apps.Users',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test roles method
     *
     * @return void
     */
    public function testRoles(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test profileImage method
     *
     * @return void
     */
    public function testProfileImage(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test synchronizeLdap method
     *
     * @return void
     */
    public function testSynchronizeLdap(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test trackHistory method
     *
     * @return void
     */
    public function testTrackHistory(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
