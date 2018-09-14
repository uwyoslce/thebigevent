<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class JobAssignmentsTable extends Table {

	public function initialize(array $config)
	{

		$this->setTable('job_assignments');

		$this->setPrimaryKey( ['group_id', 'job_id'] );

		$this->addBehavior('Timestamp');

//		$this->addBehavior('CounterCache', [
//			'Groups' => ['member_count']
//		]);

		$this->belongsTo('JobAssignments', [
			'foreignKey' => ['group_id', 'job_id'],
			'joinType' => 'INNER'
		]);

		$this->belongsTo('Groups');
		$this->belongsTo('Jobs');

		parent::initialize($config);

	}

}
