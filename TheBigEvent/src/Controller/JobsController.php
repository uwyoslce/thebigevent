<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

use Cake\Log\Log;

use Cake\ORM\TableRegistry;

use Cake\I18n\Time;
/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 */
class JobsController extends AppController
{

	public function beforeFilter(Event $event) {
		$this->Auth->allow(['request']);
		parent::beforeFilter($event);
	}

	public function isAuthorized($user) {

		if( $this->request->action === 'request' )
		{
			return true;
		}

		return parent::isAuthorized($user);
	}


	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Todos' => ['Users']]
		];
		$jobs = $this->paginate($this->Jobs);

		$this->set(compact('jobs'));
		$this->set('_serialize', ['jobs']);
	}

	public function note($job_id) {
		$job = null;
		$result = null;

		if( 'admin' == $this->Auth->user('role') ) {
			if( $this->request->is(['put', 'post'])) {
				$job = $this->Jobs->get($job_id);

				if( $job ) {
					$newNotes = sprintf("%s: %s",
						$this->Auth->user('username'),
						$this->request->data['note']
					);
					$job->notes = trim($job->notes . "\n\n" . $newNotes);

					$result = $this->Jobs->save($job);
				}
			}
		}
		
		$this->set('job', $job);
		$this->set('_serialize', ['job']);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Job id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$job = $this->Jobs->get($id, [
			'contain' => ['Tasks', 'Todos' => ['Users']]
		]);

		// $todos = TableRegistry::get('Todos')->find('all', [
		// 	'conditions' => [
		// 		'model' => 'Jobs',
		// 		'model_id' => $id
		// 	],
		// 	'contain' => ['Users'],
		// 	'order' => [
		// 		'due' => 'ASC'
		// 	]
		// ]);

		$this->set('job', $job);
		//$this->set('todos', $todos);
		$this->set('_serialize', ['job']);
	}

	/**
	 * Add method
	 * http://stackoverflow.com/questions/26027222/how-do-you-get-the-last-insert-id-in-cakephp-3-0
	 *
	 * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
	 */
	public function request()
	{
		$job = $this->Jobs->newEntity();
		if ($this->request->is('post')) {

			$templates = TableRegistry::get('TodoTemplates');
			$Todos = TableRegistry::get('Todos');
			$users = TableRegistry::get('Users');

			$job = $this->Jobs->patchEntity($job, $this->request->data);
			if (($result = $this->Jobs->save($job)) && $result) {

				$candidate_user = $this->getLeastBusyUser();

				$todos = [];

				foreach( $templates->find('all') as $todoTemplate ) {
					array_push(	$todos, $Todos->newEntity([
							'model' => 'Jobs',
							'model_id' => $result->job_id,
							'user_id' => $candidate_user->user_id,
							'description' => $todoTemplate->description,
							'long_description' => $todoTemplate->long_description,
							'due' => new Time($todoTemplate->due_description),
							'completed' => false
						]
					) );
				}

				$Todos->saveMany($todos);

				$evt = new Event('Job.Created', $this, [
					'job' => $job
				]);
				$this->eventManager()->dispatch($evt);

				$this->Flash->success(__('The job has been saved.'));
				return $this->redirect(['controller' => 'pages', 'action' => 'index']);
			} else {
				$this->Flash->error(__('The job could not be saved. Please, try again.'));
			}
		}
		$jobs = $this->Jobs->Jobs->find('list', [
			'limit' => 200]);
		$tasks = $this->Jobs->Tasks->find('list', [
			'order' => 'title',
			'limit' => 200]);
		$this->set( compact('job', 'jobs', 'tasks') );
		$this->set( '_serialize', ['job']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Job id.
	 * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$job = $this->Jobs->get($id, [
			'contain' => ['Tasks']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$job = $this->Jobs->patchEntity($job, $this->request->data);
			if ($this->Jobs->save($job)) {

				$event = new Event('Job.Modified', $this, [
					'job_id' => $job->job_id
				]);
				$this->eventManager()->dispatch($event);

				$this->Flash->success(__('The job has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The job could not be saved. Please, try again.'));
			}
		}
		$jobs = $this->Jobs->Jobs->find('list', ['limit' => 200]);
		$tasks = $this->Jobs->Tasks->find('list', ['limit' => 200]);
		$this->set(compact('job', 'jobs', 'tasks'));
		$this->set('_serialize', ['job']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Job id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $job = $this->Jobs->get($id);
        if ($this->Jobs->delete($job)) {
            $this->Flash->success(__('The job has been deleted.'));
        } else {
            $this->Flash->error(__('The job could not be deleted. Please, try again.'));
        }
        $redirect = ['action' => 'index'];
        if( $this->request->referer() ) {
        	$redirect = $this->request->referer();
        }

        return $this->redirect($redirect);
    }
 }
