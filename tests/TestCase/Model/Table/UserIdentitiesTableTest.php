<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserIdentitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserIdentitiesTable Test Case
 */
class UserIdentitiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserIdentitiesTable
     */
    public $UserIdentities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_identities',
        'app.userentities',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('UserIdentities') ? [] : ['className' => 'App\Model\Table\UserIdentitiesTable'];
        $this->UserIdentities = TableRegistry::get('UserIdentities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserIdentities);

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
