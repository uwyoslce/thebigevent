<?php
namespace App\Model\Table;

use App\Model\Entity\TodoTemplate;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TodosTemplates Model
 *
 * @property \Cake\ORM\Association\BelongsTo $TodoTemplates
 */
class TodoTemplatesTable extends Table
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

        $this->setTable('todos_templates');
        $this->setDisplayField('todo_template_id');
        $this->setPrimaryKey('todo_template_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('TodoTemplates', [
            'foreignKey' => 'todo_template_id',
            'joinType' => 'INNER'
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
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('long_description', 'create')
            ->notEmpty('long_description');

        $validator
            ->requirePresence('due_description', 'create')
            ->notEmpty('due_description');

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
        $rules->add($rules->existsIn(['todo_template_id'], 'TodoTemplates'));
        return $rules;
    }
}
