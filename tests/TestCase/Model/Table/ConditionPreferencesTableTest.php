<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConditionPreferencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConditionPreferencesTable Test Case
 */
class ConditionPreferencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConditionPreferencesTable
     */
    public $ConditionPreferences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.condition_preferences',
        'app.conditions',
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
        $config = TableRegistry::getTableLocator()->exists('ConditionPreferences') ? [] : ['className' => ConditionPreferencesTable::class];
        $this->ConditionPreferences = TableRegistry::getTableLocator()->get('ConditionPreferences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ConditionPreferences);

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
