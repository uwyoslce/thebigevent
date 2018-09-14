<?php
namespace App\Test\TestCase\Controller;

use App\Controller\OrganizationController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\OrganizationController Test Case
 */
class OrganizationControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.organization',
        'app.job',
        'app.organizations',
        'app.teams',
        'app.job_issues',
        'app.job_tools',
        'app.organization_has_job',
        'app.user_has_organization',
        'app.user_has_participation_request'
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

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
