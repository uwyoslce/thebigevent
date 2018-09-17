<?php 
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Mailer\Email;

class EmailShell extends Shell {

    public function main() {
        $this->out('Hello world.');
    }

    public function preflight() {
        $identities = $this->UserIdentities
			->find()
			->where([
				'protocol' => 'token',
				'realm' => 'uwyobigevent.com',
                'UserIdentities.user_identity_id >' => 2356
			])
			->contain([
				'Users' => [
					'Signatures' => ['Documents'],
					'Groups' => [
						'Jobs' => ['SiteLeader'],
						'Users' => []
					]
				]
			])
            ->order([
                'user_identity_id' => 'asc'
            ]);

        $this->out("Beginning preflight send...");
        foreach($identities as $identity) {
            try {
            $this->out( "\t" . $identity->user->full_name . " at " . $identity->user_identity_id . "...");
            $email = new Email('default');
            $email
                ->to($identity->user->email)
                ->attachments([
                    'qr.png' => [
                        'data' => file_get_contents( __('https://api.qrserver.com/v1/create-qr-code/?data={0}&size={1}x{1}&ecc={2}&qzone={3}&format={4}', [
                            urlencode($identity->identifier), // data
                            300, // size
                            "M", // error correction
                            5, // quiet zone (in units of image blocks)
                            'png' // file format
                        ]) ),
                        'mimetype' => 'image/png',
                        'contentId' => $identity->identifier
                    ]
                ])
                ->viewVars([
                    'identity' => $identity,
                    'qr_source' => 'attachment'
                ])
                ->subject(__("[{0}] PLEASE READ! We'll see you tomorrow at 9 AM", [
                	Configure::read("TheBigEvent.name")
                ]) )
                ->template('preflight')
                ->emailFormat('html');

            if( $email->send() ) {
                $this->out("\t\t...done");
            }
            } catch (Exception $e) {
                $this->out("ERROR: " . $identity->user_identity_id);
            }

        }
        $this->out("...preflight complete");
        
    }

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('UserIdentities');
    }
}