<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class MembershipsTable extends Table {

	public function initialize(array $config)
	{

		$this->setTable('membership');

		$this->setPrimaryKey( ['group_id', 'user_id'] );

		$this->addBehavior('Timestamp');

		$this->addBehavior('CounterCache', [
		 	'Groups' => [
				 'member_count'
			]
		]);

		$this->belongsTo('Memberships', [
			'foreignKey' => ['group_id', 'user_id'],
			'joinType' => 'INNER'
		]);

		$this->belongsTo('Users');
		$this->belongsTo('Groups');

		parent::initialize($config);

	}

}
