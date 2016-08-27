<?php

namespace App\Event;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Mailer\Email;
use Cake\Log\Log;

class EmailListener implements EventListenerInterface
{
    public function implementedEvents()
    {
    	return [
    		'Job.Created' => 'sendConfirmationEmailToUser'
    	];
    }

    public function sendConfirmationEmailToUser(Event $event, $data) {

    	$job = $event->data['job'];

    	Log::write('debug', print_r($job, true) );
		$email = new Email('gmail');
		$email
		->viewVars([
			'job' => $job
		])
		->emailFormat('both')
		->template('jobRequestConfirmation')
		->to($job->contact_email)
		->subject( sprintf("[The Big Event] We have received your job request!"))
		->send();
    }

}