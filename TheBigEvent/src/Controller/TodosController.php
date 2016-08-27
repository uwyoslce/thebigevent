<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Todos Controller
 *
 * @property \App\Model\Table\TodosTable $Todos
 */
class TodosController extends AppController
{

	public function initialize() {
		parent::initialize();
        $this->loadComponent('RequestHandler');
	}

	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index($who = 'me', $status = 'incomplete')
	{
		$paginate = [
			'contain' => ['Users','Jobs'],
			'order' => [
				'due' => 'ASC'
			]
		];

		if( 'me' == $who ) {
			$paginate['conditions']['Todos.user_id'] = $this->Auth->user('user_id');
		}
		
		if( 'incomplete' == $status ) {
			$paginate['conditions']['completed'] = false;
		}

		if( 'complete' == $status ) {
			$paginate['conditions']['completed'] = true;
		}

		if( 'overdue' == $status ) {
			$paginate['conditions']['due <'] = new Time();
		}

		$this->paginate = $paginate;
		$todos = $this->paginate($this->Todos);

		$this->set('request', $this->request);
		$this->set(compact('todos', 'who', 'status'));
		$this->set('_serialize', ['todos']);
	}

	public function me() {
		return $this->redirect([
			'action' => 'index',
			'me',
			'incomplete'
		]);
	}

	public function status($todo_id, $status) {
		$todo = null;
		if( in_array($status, ['complete', 'incomplete']) ) {
			$query = $this->Todos->find('all', [
				'conditions' => [
					"todo_id" => $todo_id,
					"user_id" => $this->Auth->user('user_id')
				]
			]);

			$todo = $query->first();
			if( $todo ) {
				$todo->completed = $status == "complete" ? true : false;
				if( ($result = $this->Todos->save($todo)) && $result ) {
					//
				} else {
					throw new InternalErrorException('Something happened with the server');
				}
			}
		}
		$this->set('todo', $todo);
		$this->set('_serialize', ['todo']);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Todo id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$todo = $this->Todos->get($id, [
			'contain' => [ 'Users']
		]);

		$Model = TableRegistry::get($todo->model);
		$related_entity = $Model->get($todo->model_id);

		$this->set('todo', $todo);
		$this->set('related_entity', $related_entity);
		$this->set('_serialize', ['todo']);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$todo = $this->Todos->newEntity();
		if ($this->request->is('post')) {
			$todo = $this->Todos->patchEntity($todo, $this->request->data);
			if ($this->Todos->save($todo)) {
				$this->Flash->success(__('The todo has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The todo could not be saved. Please, try again.'));
			}
		}
		$todos = $this->Todos->Todos->find('list', ['limit' => 200]);
		$users = $this->Todos->Users->find('list', ['limit' => 200]);
		$this->set(compact('todo', 'todos', 'users'));
		$this->set('_serialize', ['todo']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Todo id.
	 * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$todo = $this->Todos->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$todo = $this->Todos->patchEntity($todo, $this->request->data);
			if ($this->Todos->save($todo)) {
				$this->Flash->success(__('The todo has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The todo could not be saved. Please, try again.'));
			}
		}
		$todos = $this->Todos->Todos->find('list', ['limit' => 200]);
		$users = $this->Todos->Users->find('list', ['limit' => 200]);
		$this->set(compact('todo', 'todos', 'jobs', 'users'));
		$this->set('_serialize', ['todo']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Todo id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$todo = $this->Todos->get($id);
		if ($this->Todos->delete($todo)) {
			$this->Flash->success(__('The todo has been deleted.'));
		} else {
			$this->Flash->error(__('The todo could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}
}
