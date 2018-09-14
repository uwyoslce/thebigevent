<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SignaturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SignaturesTable Test Case
 */
class SignaturesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SignaturesTable
     */
    public $Signatures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.signatures',
        'app.users',
        'app.user_identities',
        'app.conditions',
        'app.jobs',
        'app.tasks',
        'app.jobs_tasks',
        'app.todos',
        'app.jobs_conditions',
        'app.tools',
        'app.job_tools',
        'app.conditions_users',
        'app.groups',
        'app.memberships',
        'app.documents'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Signatures') ? [] : ['className' => 'App\Model\Table\SignaturesTable'];
        $this->Signatures = TableRegistry::get('Signatures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Signatures);

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
