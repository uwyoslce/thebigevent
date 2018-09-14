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
class ToolsTable extends Table
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

        $this->setTable('tools');
        $this->setDisplayField('title');
        $this->setPrimaryKey('tool_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tools', [
            'foreignKey' => 'tool_id',
            'joinType' => 'INNER'
        ]);
	    $this->belongsToMany('Jobs', [
		    'through' => 'JobTools'
	    ]);
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');


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
        $rules->add($rules->existsIn(['tool_id'], 'Tools'));
        return $rules;
    }
}
