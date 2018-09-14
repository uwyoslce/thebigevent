<?php
namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class AppController extends Controller {

	use \Cake\Log\LogTrait;

	public function initialize() {
		$this->loadComponent('RequestHandler');/*This line loads the required RequestHandler Component*/
		$this->loadComponent('Auth', [
			'authenticate' => [
				"Token"
			],
			'storage' => 'Memory',
			'unauthorizedRedirect' => false,
			'authorize' => 'Controller'
		]);
	    parent::initialize();
	}

	public function getPaging($model) {
		$param = $this->request->getParam('paging');
		$paging = $param[$model];
		return [
			"currentPage" => $paging['page'],
			"currentCount" => $paging['current'],
			"hasPrevPage" => $paging['prevPage'],
			"hasNextPage" => $paging['nextPage'],
			"totalPages" => $paging['pageCount'],
			"totalCount" => $paging['count'],
		];
	}

	public function cors() {
		if ($this->request->is('OPTIONS')) {
		
		}
	}

	public function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);

	}


	public function isAuthorized($user) {
		return $user['role'] === "admin";
		return parent::isAuthorized($user);
	}
}
