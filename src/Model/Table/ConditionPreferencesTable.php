<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ConditionPreferences Model
 *
 * @property \App\Model\Table\ConditionsTable|\Cake\ORM\Association\BelongsTo $Conditions
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ConditionPreference get($primaryKey, $options = [])
 * @method \App\Model\Entity\ConditionPreference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ConditionPreference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ConditionPreference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ConditionPreference|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ConditionPreference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ConditionPreference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ConditionPreference findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ConditionPreferencesTable extends Table
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

        $this->setTable('condition_preferences');
        $this->setDisplayField('condition_preference_id');
        $this->setPrimaryKey('condition_preference_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Conditions', [
            'foreignKey' => 'condition_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->integer('condition_preference_id')
            ->allowEmpty('condition_preference_id', 'create')
            ->add('condition_preference_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['condition_preference_id']));
        $rules->add($rules->existsIn(['condition_id'], 'Conditions'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
