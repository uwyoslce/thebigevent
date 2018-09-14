<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Signatures Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Signatures
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Documents
 *
 * @method \App\Model\Entity\Signature get($primaryKey, $options = [])
 * @method \App\Model\Entity\Signature newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Signature[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Signature|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Signature patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Signature[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Signature findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SignaturesTable extends Table
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

        $this->setTable('signatures');
        $this->setDisplayField('signature_id');
        $this->setPrimaryKey('signature_id');

        $this->addBehavior('Timestamp');

	    $this->addBehavior('CounterCache', [
	    	'Documents' => [
	    		'distributed_count' => [],
			    'signed_count' => [
			    	'conditions' => ['Signatures.signed' => true]
			    ]
		    ],
		    'Users' => [
		    	'signatures_unsigned' => [
		    		'conditions' => ['Signatures.signed' => false]
		    	]
		    ]
	    ]);

        $this->belongsTo('Signatures', [
            'foreignKey' => 'signature_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Documents', [
            'foreignKey' => 'document_id'
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
            ->boolean('signed')
            ->requirePresence('signed', 'create')
            ->notEmpty('signed')
	        ->allowEmpty('signature_text');

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
        $rules->add($rules->existsIn(['signature_id'], 'Signatures'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['document_id'], 'Documents'));

        return $rules;
    }
}
