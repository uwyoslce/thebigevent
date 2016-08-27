<?php
namespace App\Controller;

use Cake\Core\Configure;
use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->deny();
		$this->Auth->allow(['add', 'logout', 'cas']);

		$ok = @session_start();
		if(!$ok){
			session_regenerate_id(true); // replace the Session ID
			session_start(); 
		}

	}

	public function me() {
		$query = $this->Users->find('all', [
			'conditions' => [
				'Users.user_id' => $this->Auth->user('user_id')
			],
			'contain' => ['UserIdentities']
		]);
		$user = $query->first();
		$this->set( compact('user') );
	}

	public function cas($mode = 'login', $user_identity_id = null) {

		$cas = Configure::read('CAS');
		\phpCAS::client(
			CAS_VERSION_2_0, 
			$cas['host'], 
			$cas['port'], 
			$cas['context'],
			false
		);

		if( Configure::read('debug') ) {
			\phpCAS::setNoCasServerValidation();
		} else {
			// TODO: implement the server certs
		}

		$user = null;
		$user_identity = null;

		if( \phpCAS::isAuthenticated() ) {
			$query = $this->Users->UserIdentities->find('all', [
				'conditions' => [
					'protocol' => 'cas',
					'realm' => $cas['host'],
					'identifier' => \phpCAS::getUser()
				],
				'contain' => ['Users']
			]);

			$user_identity = $query->first();
		} else {
			\phpCAS::forceAuthentication();
		}

		switch( trim( strtolower($mode) ) ){

			case 'merge':
				// This identity doesn't exist && user is logged in
				if( null == $user_identity && $this->Auth->user() ) {
					$user = $this->Users->get( $this->Auth->user('user_id') );
					$user->user_identities = [
						$this->Users->UserIdentities->newEntity([
							'protocol' => 'cas',
							'realm' => $cas['host'],
							'identifier' => \phpCAS::getUser()
						])
					];

					if( $this->Users->save($user) )
					{
						//$this->Flash->success('You have successfully connected your accounts');
					}
				}
				break;
			case 'disconnect':
				if( $this->Auth->user() && $this->request->is('post') ) {
					$query = $this->Users->UserIdentities->find('all', [
						'conditions' => [
							'UserIdentities.user_id' => $this->Auth->user('user_id'),
							'UserIdentities.user_identity_id' => $user_identity_id
						]
					]);

					$user_identity = $query->first();

					if( $user_identity && $this->Users->UserIdentities->delete($user_identity) ) {
						//$this->Flash->success('This identity has been disconnected');
					}
				}
				break;
			case 'login':              
				if( \phpCAS::isAuthenticated() ) {			

					if( null == $user_identity ) {
						// create new user and useridentity

						$newUser = $this->Users->newEntity(
							call_user_func_array($cas['user_builder'], [
								\phpCAS::getUser(),
								\phpCAS::getAttributes()
							])
						);
						$newUser->role = 'volunteer';
						$newUser->time_zone = $this->getTimeZone();

						$newUser->user_identities = [
							$this->Users->UserIdentities->newEntity([
								'protocol' => 'cas',
								'realm' => $cas['host'],
								'identifier' => \phpCAS::getUser()
							])
						];

						$this->Users->save($newUser);
						$this->Auth->setUser( $newUser->toArray() );

					} else {
						$this->Auth->setUser( $user_identity->user->toArray() );
					}

				} 
				break;
			case 'logout':
				if( \phpCAS::isAuthenticated() )
				{
					\phpCAS::logout();
				}
				break;
		}        

		return $this->redirect([
			'action' => 'me'
		]);

	}

	 public function index()
	 {
		$this->set('users', $this->Users->find('all'));
	}

	public function view($id)
	{
		$user = $this->Users->get($id);
		$this->set(compact('user'));
	}

	public function add()
	{
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			$user->role = 'volunteer';
			$user->timeZone = $this->getTimeZone();
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'add']);
			}
			$this->Flash->error(__('Unable to add the user.'));
		}
		$this->set('user', $user);
	}

	
	public function login()
	{
		if( !$this->Auth->user() ) {
			if ($this->request->is('post')) {
				$user = $this->Auth->identify();
				if ($user) {
					$this->Auth->setUser($user);
					return $this->redirect($this->Auth->redirectUrl());
				}
				$this->Flash->error(__('Invalid username or password, try again'));
			}
		}
	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}

	private function getTimeZone() {
		$ip = $_SERVER['REMOTE_ADDR'];
		$response = file_get_contents("https://freegeoip.net/json/$ip");
		$decoded = json_decode($response);
		if($decoded->time_zone)
			return $decoded->time_zone;
		else
			return "";
	}

}