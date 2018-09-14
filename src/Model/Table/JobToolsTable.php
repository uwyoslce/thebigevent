<?php
namespace App\Model\Table;

use App\Model\Entity\Condition;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tags Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Tags
 * @property \Cake\ORM\Association\BelongsToMany $Jobs
 */
class JobToolsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('jobs_tools');
        $this->setPrimaryKey(['job_id', 'tool_id']);

        $this->addBehavior('Timestamp');

	    $this->belongsTo('Tools');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
    	$validator
		    ->requirePresence('count', 'create')
		    ->range('count', [1, PHP_INT_MAX]); // at least one required tool

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
//        $rules->add($rules->existsIn(['tool_id'], 'Tools'));
//	    $rules->add($rules->existsIn(['job_id'], 'Jobs'));
        return $rules;
    }
}
