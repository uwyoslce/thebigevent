<?php
namespace App\Model\Table;

use App\Model\Entity\Job;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Jobs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 * @property \Cake\ORM\Association\BelongsToMany $Tasks
 */
class JobsTable extends Table
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

        $this->table('jobs');
        $this->displayField('display_field');
        $this->primaryKey('job_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Tasks', [
            'foreignKey' => 'job_id',
            'targetForeignKey' => 'task_id',
            'joinTable' => 'jobs_tasks'
        ]);
        $this->hasMany('Todos', [
            'dependent' => true,
            'foreignKey' => 'model_id',
            'bindingKey' => 'job_id',
            'conditions' => [
                'Todos.model' => 'Jobs'
            ]
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
            ->requirePresence('contact_first_name', 'create')
            ->notEmpty('contact_first_name');

        $validator
            ->requirePresence('contact_last_name', 'create')
            ->notEmpty('contact_last_name');

        $validator
            ->requirePresence('contact_phone', 'create')
            ->notEmpty('contact_phone');

        $validator
            ->requirePresence('contact_email', 'create')
            ->add('contact_email', 'validFormat', [
                'rule' => 'email',
                'message' => 'E-mail must be valid'
            ])  
            ->notEmpty('contact_email');

        $validator
            ->add('volunteer_count', 'integer', [
                'rule' => ['naturalNumber', false],
                'message' => 'Please enter an estimated number of volunteers greater than zero'
                ]
            )
            ->requirePresence('volunteer_count', 'create')
            ->notEmpty('volunteer_count');

        $validator
            ->requirePresence('contact_address_1', 'create')
            ->notEmpty('contact_address_1');

        $validator
            ->requirePresence('contact_city', 'create')
            ->notEmpty('contact_city');

        $validator
            ->requirePresence('contact_state', 'create')
            ->notEmpty('contact_state');

        $validator
            ->requirePresence('contact_zip', 'create')
            ->notEmpty('contact_zip');

        $validator
            ->requirePresence('contact_best_time_to_call', 'create')
            ->notEmpty('contact_best_time_to_call');

        $validator
            ->requirePresence('referral', 'create')
            ->notEmpty('referral');

        $validator
            ->requirePresence('job_description', 'create')
            ->notEmpty('job_description');

        $validator
            ->boolean('accepted_agreements')
            ->add('accepted_agreements', [
                'isTrue' => [
                    'rule' => ['equalTo', '1'],
                    'message' => 'You must accept the terms of the Job Site Request agreements'
                ]])
            ->requirePresence('accepted_agreements', 'create')
            ->notEmpty('accepted_agreements');

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
        $rules->add($rules->existsIn(['job_id'], 'Jobs'));
        return $rules;
    }
}
