<?php
declare(strict_types=1);

namespace Apps\Test\TestCase\Controller;

use Apps\Controller\FilesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Apps\Controller\FilesController Test Case
 *
 * @uses \Apps\Controller\FilesController
 */
class FilesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.Apps.Files',
        'plugin.Apps.MimeType',
        'plugin.Apps.Users',
        'plugin.Apps.AppLinks',
        'plugin.Apps.MimeTypes',
    ];

    /**
     * Test beforeFilter method
     *
     * @return void
     */
    public function testBeforeFilter(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

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
     * Test browse method
     *
     * @return void
     */
    public function testBrowse(): void
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
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test open method
     *
     * @return void
     */
    public function testOpen(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test download method
     *
     * @return void
     */
    public function testDownload(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test resize method
     *
     * @return void
     */
    public function testResize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test css method
     *
     * @return void
     */
    public function testCss(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test upload method
     *
     * @return void
     */
    public function testUpload(): void
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
