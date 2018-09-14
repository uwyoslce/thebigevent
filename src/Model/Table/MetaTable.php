<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class MetaTable extends Table {

	public function initialize(array $config)
	{

		$this->setTable('meta');

		$this->setPrimaryKey( 'meta_id' );

		$this->addBehavior('Timestamp');

		$this->belongsTo('Jobs', [
            'foreignKey' => 'model_id',
            'conditions' => [
                'Meta.model' => 'Jobs'
            ]
        ]);

		parent::initialize($config);

	}

}
