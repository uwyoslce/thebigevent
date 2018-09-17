<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Class UsersTable
 * @package App\Model\Table
 * @property
 */
class UsersTable extends Table
{
	public function initialize(array $config) {

		$this->setTable('users');
		$this->setDisplayField('full_name');
		$this->setPrimaryKey('user_id');

		$this->addBehavior('Timestamp');

		/**
		 * Associations
		 */
		$this->hasMany('UserIdentities');
		$this->hasMany('Signatures');
		$this->hasMany('Todos' );

		$this->hasMany('SiteLeaderJobs', [
			'className' => 'Jobs',
			'foreignKey' => 'site_leader_id',
			'bindingKey' => 'user_id'
		]);
		
		$this->belongsToMany('Conditions', [
			'through' => 'condition_preferences'
		]);

		$this->belongsToMany('Groups', [
			'through' => 'Memberships'
		]);

		parent::initialize($config);
	}

	public function findLeaders(Query $query, array $options) {
		return $query->where([
			'role <>' => 'volunteer'
		]);
	}
	
	public function findVolunteers(Query $query, array $options) {
		return $query->where([
			'role' => 'volunteer'
		]);
	}

	public function validationDefault(Validator $validator)
	{
		return $validator
			->notEmpty('first_name', 'Your first name is required')
			->notEmpty('last_name', 'Your last name is required')
			->notEmpty('username', 'A username is required')
			->notEmpty('time_zone', 'A time zone is required to save the user')
			->notEmpty('email', 'An email address is required.')
			->notEmpty('address_1', __('Please provide at least one line of your address') )
			->allowEmpty('address_2')
			->notEmpty('city', __('Please input your city of residence') )
			->notEmpty('state', __('Please input your state of residence') )
			->notEmpty('zip_code', __('Please input your zip code') )
			->add('shirt_size', 'inList', [
				'rule' => ['inList', ['?', 'S', 'M', 'L', 'XL', 'XXL']],
				'message' => 'Please select a shirt size',
			])
			->add('transportation', 'inList', [
				'rule' => ['inList', ['can_drive', 'cannot_drive']],
				'message' => 'Please select a transportation option'
			])
			->nonNegativeInteger('vehicle_capacity')
			->email('email')
			->add('username', 'unique', [
				'rule' => 'validateUnique',
				'provider' => 'table',
				'message' => 'That username is already taken.'
			])
			->notEmpty('password', 'A password is required')
			->notEmpty('role', 'A role is required')
			->add('role', 'inList', [
				'rule' => ['inList', ['admin', 'volunteer', 'committee']],
				'message' => 'Please enter a valid role'
			]);
	}

}
