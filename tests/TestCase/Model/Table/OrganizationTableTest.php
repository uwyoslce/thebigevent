<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrganizationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrganizationTable Test Case
 */
class OrganizationTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OrganizationTable
     */
    public $Organization;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Organization') ? [] : ['className' => 'App\Model\Table\OrganizationTable'];
        $this->Organization = TableRegistry::get('Organization', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Organization);

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
