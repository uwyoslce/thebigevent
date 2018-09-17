<?php

namespace App\Event;

use App\Model\Entity\Job;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Http\Client;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;


class GeocodeListener implements EventListenerInterface
{
    use LogTrait;

    private $apiKey = "";
	
	function __construct($apiKey)
	{
	    $this->apiKey = $apiKey;
	    $this->log("GeocodeListener constructed with api key: ". $this->apiKey, "info");
	}

    public function implementedEvents()
    {
    	return [
    		'Job.afterSave' => 'afterSave'
    	];
    }

    public function afterSave(Event $event, $job) {

        $Meta = TableRegistry::get("Meta");

        $Meta->deleteAll([
            'model' => 'Jobs',
            'model_id' => $job->job_id,
            'meta_key IN' => ['latitude', 'longitude']
        ]);

        $http = new Client();
        // ?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=YOUR_API_KEY
        $resp = $http->get("https://maps.googleapis.com/maps/api/geocode/json", [
            "address" => $job->address,
            "key" => $this->apiKey
        ]);

        $result = $resp->json;

        if( $result['results'][0]['geometry']['location'] ) {
            $location =  $result['results'][0]['geometry']['location'] ;
            $metas = $Meta->newEntities([
                [
                    'model' => "Jobs",
                    'model_id' => $job->job_id,
                    'meta_key' => 'latitude',
                    'meta_value' => $location['lat']
                ],
                [
                    'model' => "Jobs",
                    'model_id' => $job->job_id,
                    'meta_key' => 'longitude',
                    'meta_value' => $location['lng']
                ]
            ]);

            $Meta->saveMany($metas);
        }


    }

}