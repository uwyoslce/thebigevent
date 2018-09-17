<?php

namespace App\Event;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Mailer\Email;
use Cake\Log\Log;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;

class EmailListener implements EventListenerInterface
{
    public function implementedEvents()
    {
    	return [
    		'Job.Created' => 'sendConfirmationEmailToUser',
		    'User.Created' => 'welcomeNewUser',
			'User.checkedIn' => 'checkedIn'
    	];
    }

    public function __construct($email_config = 'default') {
        $this->email_config = $email_config;
    }

	public function preflight() {

	}

	public function checkedIn(Event $event, $data) {
		$identity = $event->data['identity'];

		$email = new Email( $this->email_config );
		$qrCode = new QrCode($identity->identifier);
		$qrCode->setSize(600)
			    ->setWriterByName('png')
				->setMargin(60)
				->setEncoding('UTF-8')
				->setErrorCorrectionLevel(ErrorCorrectionLevel::MEDIUM)
				->setValidateResult(true)
		;

		$email->setViewVars([
				'identity' => $event->data['identity'],
				'qr_source' => 'attachment'
			])
			->setEmailFormat('html')
			->setTemplate('checked_in')
			->setTo( $event->data['identity']->user->email )
			//->setTo('bradkovach@gmail.com')
			->setSubject("[{0}] You're checked in. Here's everything you need to know.", [
				Configure::read('TheBigEvent.name')
			])
			->send();
	}

	public function sendConfirmationEmailToUser(Event $event, $data) {

    	$job = $event->getData()['job'];

		$email = new Email( $this->email_config );
		$email
		->setViewVars([
			'job' => $job
		])
		->setEmailFormat('both')
		->setTemplate('jobRequestConfirmation')
		->setTo($job->contact_email)
		->setSubject( __("[{0}] We have received your job request!", [
			Configure::read('TheBigEvent.name')
		]))
		->send();
    }

    public function welcomeNewUser(Event $event, $data) {
    	$user = $event->data['user'];

	    $email = new Email( $this->email_config );

	    $email
		    ->setViewVars([
		    	'user' => $user
		    ])
		    ->setEmailFormat('both')
		    ->setTemplate('welcomeUser')
		    ->setTo($user->email)
		    ->setSubject( __("[{0}] Welcome to {0} at {1}!", [
		    	Configure::read("TheBigEvent.name"),
			    Configure::read("TheBigEvent.institutionName")
		    ]) )
		    ->send();
    }

}
