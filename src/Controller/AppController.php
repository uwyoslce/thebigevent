<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Model\Entity\User;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

use Cake\ORM\TableRegistry;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	/**
	 * @var time_zone The time zone for which to render times.
	 */
	var $time_zone;

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * e.g. `$this->loadComponent('Security');`
	 *
	 * @return void
	 */
	public function initialize()
	{
		parent::initialize();

		$this->loadComponent('RequestHandler', [
			'enableBeforeRedirect' => false
		]);
		$this->loadComponent('Flash');
		$this->loadComponent('Auth', [
			'authorize' => ['Controller'],
			'loginRedirect' => [
				'controller' => 'Users',
				'action' => 'login'
			],
			'logoutRedirect' => [
				'controller' => 'Pages',
				'action' => 'display',
				'home'
			]
		]);
		
		$AuthUser = $this->Auth->user();
		
		$this->set('AuthUser', $AuthUser );
		
		$this->time_zone = Configure::readOrFail("TheBigEvent.timeZone");
		if(null != $AuthUser) {
			$this->time_zone = $AuthUser['time_zone'];
		}
		$this->set( 'time_zone', $this->time_zone );
		
	}

	public function beforeFilter(Event $event) {
		

		parent::beforeFilter($event);
	}

	public function isAuthorized($user)
	{
		// TODO: rewire the controller permissions
		// Admin can access every action
		if ( isset($user['role']) && $user['role'] === 'admin') {
			return true;
		}

		// Default deny
		return false;
	}

	public function getLeastBusyUser(): User {
		$Users = TableRegistry::get("Users");
		$query = $Users->find('all', [
			'conditions' => [
				'role IN' => ['admin', 'committee']
			],
			'order' => [
				'todos_incomplete' => 'ASC'
			]
		]);
		return $query->first();
	}


	/**
	 * Before render callback.
	 *
	 * @param \Cake\Event\Event $event The beforeRender event.
	 * @return void
	 */
	public function beforeRender(Event $event)
	{
		if (!array_key_exists('_serialize', $this->viewVars) &&
			in_array($this->response->getType(), ['application/json', 'application/xml'])
		) {
			$this->set('_serialize', true);
		}
	}
}
