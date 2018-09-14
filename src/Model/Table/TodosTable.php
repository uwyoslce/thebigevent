<?php
namespace App\Model\Table;

use App\Model\Entity\Todo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Todos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Todos
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class TodosTable extends Table
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

		$this->setTable('todos');
		$this->setDisplayField('todo_id');
		$this->setPrimaryKey('todo_id');

		$this->addBehavior('Timestamp');

		$this->addBehavior('CounterCache', [
			'Users' => [
				'todos_incomplete' => [
					'conditions' => [
						'Todos.completed' => false
					]
				],
				'todos_complete' => [
					'conditions' => [
						'Todos.completed' => true
					]
				]
			],
			'Jobs' => [
				'todos_incomplete' => [
					'conditions' => [
						'Todos.completed' => false
					]
				],
				'todos_complete' => [
					'conditions' => [
						'Todos.completed' => true
					]
				]
			]
		]);

		$this->belongsTo('Jobs', [
			'foreignKey' => 'model_id',
			'conditions' => [
				'Todos.model' => 'Jobs'
			]
		]);

		$this->belongsTo('Todos', [
			'foreignKey' => 'todo_id',
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
			->requirePresence('description', 'create')
			->notEmpty('description');

		$validator
			->requirePresence('long_description', 'create')
			->notEmpty('long_description');

		$validator
			->dateTime('due')
			->requirePresence('due', 'create')
			->notEmpty('due');

		$validator
			->boolean('completed')
			->requirePresence('completed', 'create')
			->notEmpty('completed');

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
		$rules->add($rules->existsIn(['todo_id'], 'Todos'));
		$rules->add($rules->existsIn(['user_id'], 'Users'));
		return $rules;
	}
}
