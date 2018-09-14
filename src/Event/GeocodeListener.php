<?php

namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

use Cake\ORM\TableRegistry;

class GeocodeListener implements EventListenerInterface
{

	private $webhook_url = '';
	
	function __construct()
	{

	}

    public function implementedEvents()
    {
    	return [
    		'Job.afterSave' => 'jobSaved'
    	];
    }

    public function jobSaved(Event $event) {
        $Meta = TableRegistry::get("Meta");

        $Meta->deleteAll([
            'model' => 'Jobs',
            'model_id' => $event->getSubject()->job_id,
            'meta_key IN' => ['latitude', 'longitude']
        ]);
    }

}