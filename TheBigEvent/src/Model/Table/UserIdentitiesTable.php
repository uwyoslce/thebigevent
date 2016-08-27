<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserIdentities Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Userentities
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\UserIdentity get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserIdentity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserIdentity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserIdentity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserIdentity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserIdentity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserIdentity findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserIdentitiesTable extends Table
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

        $this->table('user_identities');
        $this->displayField('user_identity_id');
        $this->primaryKey('user_identity_id');

        $this->addBehavior('Timestamp');

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
            ->requirePresence('protocol', 'create')
            ->notEmpty('protocol');

        $validator
            ->requirePresence('realm', 'create')
            ->notEmpty('realm');

        $validator
            ->requirePresence('identifier', 'create')
            ->notEmpty('identifier');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
