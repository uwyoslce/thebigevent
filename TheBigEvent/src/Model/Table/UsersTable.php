<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
	public function initialize(array $config) {
		parent::initialize($config);

		$this->table('users');
		$this->displayField('full_name');
		$this->primaryKey('user_id');

		$this->addBehavior('Timestamp');

		$this->hasMany('UserIdentities');
	}

	public function validationDefault(Validator $validator)
	{
		return $validator
			->notEmpty('first_name', 'Your first name is required')
			->notEmpty('last_name', 'Your last name is required')
			->notEmpty('username', 'A username is required')
			->add('username', 'unique', [
				'rule' => 'validateUnique',
				'provider' => 'table',
				'message' => 'That username is already taken.'
			])
			->notEmpty('password', 'A password is required')
			->notEmpty('role', 'A role is required')
			->add('role', 'inList', [
				'rule' => ['inList', ['admin', 'volunteer']],
				'message' => 'Please enter a valid role'
			]);
	}

}