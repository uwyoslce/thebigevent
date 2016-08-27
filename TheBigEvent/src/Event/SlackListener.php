<?php

namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Mailer\Email;
use Cake\Log\Log;

class SlackListener implements EventListenerInterface
{

	private $webhook_url = '';
	
	function __construct($_webhook_url)
	{
		$this->webhook_url = $_webhook_url;
	}

    public function implementedEvents()
    {
    	return [
    		'Job.Created' => 'jobCreated'
    	];
    }

    public function jobCreated(Event $event)
    {

    	$job = $event->data['job'];

    	$this->slack_advanced([
    		'text' => sprintf("A new job request has been submitted."),
    		'attachments' => [
    			[
    				'title' => sprintf("Job #%d", $job->job_id),
    				'title_link' => sprintf("https://uwyobigevent.com/jobs/view/%d", $job->job_id),
    				'color' => 'good',
    				'fields' => [
    					['title' => 'Name', 'value' => $job->contact_first_name . ' ' . $job->contact_last_name, 'short' => true],
    					['title' => 'Phone', 'value' => $job->contact_phone, 'short' => true],
    					['title' => 'Best Time To Call', 'value' => $job->contact_best_time_to_call, 'short' => true],
    					['title' => 'Referred by', 'value' => $job->referral, 'short' => true],
    					['title' => 'Description', 'value' => $job->job_description, 'short' => false],
    					['title' => 'Volunteers Requested', 'value' => $job->volunteer_count, 'short' => true],
    					['title' => 'Address', 'value' => $job->contact_address_1, 'short' => true],
    				]
    			]
    		]
    	]);

    	//$this->slack( sprintf("A new job request (#%d) has been submitted.", $job->job_id) );

    }

    private function slack($message)
	{
		$this->slack_advanced(array(
			'text' => $message,
		));
	}
	
	private function slack_advanced($payload)
	{
		$data = "payload=" . json_encode($payload);
	
		// You can get your webhook endpoint from your Slack settings
		$ch = curl_init( $this->webhook_url );
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
	}

}