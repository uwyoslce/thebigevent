<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

use Cake\Log\Log;

use Cake\ORM\TableRegistry;

use Cake\I18n\Time;
use Cake\Utility\Hash;

/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 */
class JobsController extends AppController
{

	public function beforeFilter(Event $event) {
		$this->Auth->allow([
			'request'
		]);
		parent::beforeFilter($event);
	}

	public function isAuthorized($user) {
		$perms = [
			'index' => [
				'committee' => true,
				'admin' => true,
			],
			'edit' => [
				'committee' => true,
				'admin' => true,
			],
			'note' => [
				'committee' => true,
				'admin' => true,
			],
			'view' => [
				'committee' => true,
				'admin' => true,
			],
			'report' => [
				'committee' => true,
				'admin' => true,
			],
			'request' => [
				'admin' => true,
				'committee' => true,
			],
			'claim' => [
				'admin' => true,
				'committee' => true
			], 
			'map' => [
				'admin' => true,
				'committee' => true
			],
			'todo' => [
				'admin' => true,
				'committee' => false
			]
		];

		if( isset( $perms[ $this->request->getParam('action') ][ $user['role'] ]) ) {
			return $perms[ $this->request->getParam('action') ][ $user['role'] ];
		}

		return parent::isAuthorized( $user );

	}

	private function take($group_id = null) {

	}


	public function assign($job_filter = 'unassigned', $group_filter = 'unassigned') {

		//throw new \Cake\Network\Exception\NotAcceptableException('Come back later, please');

		$Assignments = TableRegistry::get('JobAssignments');
		$Jobs = TableRegistry::get('Jobs');
		$Groups = TableRegistry::get('Groups');
		
		if( $this->request->is(['post', 'patch']) ) {

			$group_id = $this->request->getData('group_id');
			$job_id = $this->request->getData('job_id');
			$take = $this->request->getData('take');

			$job = $Jobs->get($job_id);
			$existing_group = $Groups->get($group_id, [
					'contain' => [
						'Users'
					]
				]);

			if( $take ) {

				// determine job volunteer requirement
				$volunteers_needed = $job->volunteer_count;

				if( $existing_group->member_count < $volunteers_needed ) {
					return;
				}

				// create new group
				
				$new_group = $Groups->newEntity([
					'title' => trim( $existing_group->title ) . " - Job " . $job_id,
					'join_token' =>  time(),
					'member_count' => $volunteers_needed,
					'participating_member_count' => 0,
					'capacity' => $volunteers_needed,
					'checked_in_member_count' => 0,
					'users' => [],
				]);

				// take $volunteers_needed members from existing group
				for($i = 0; $i < $volunteers_needed; $i++) {
					$current_user = array_shift($existing_group->users);
					$new_group->users[] = $current_user;
				}

				$job->groups = [
					$new_group
				];


				$job->dirty('groups', true);
				$existing_group->dirty('users', true);

				if(
					$this->Jobs->save($job, [
						'associated' => [
							'Groups' => ['Users']
						]
					])
					&& $this->Jobs->Groups->save($existing_group, [
						'associated' => ['Users']
					])
				) {

				} else {
					throw new Exception("An error occurred");
				}




			} else {
				$assignment = $Assignments->newEntity($this->request->getData());			
				$Assignments->save($assignment);
			}

			//$assignment = $Assignments->newEntity($this->request->getData());			
			//$Assignments->save($assignment);
		}

		$job_conditions = [];
		if( 'unassigned' === $job_filter)
			$job_conditions = [
				'job_id NOT IN' => $Assignments->find()->select(['job_id'])
			];

		$jobs = $this->Jobs->find('list', [
			'valueField' => function($e) {
				return __('{0} - {1} volunteers needed', [$e->get('display_field'), $e->get('volunteer_count')] );
			},
			'conditions' => $job_conditions,
			'order' => [
				'volunteer_count' => 'ASC'
			]
		]);

		$group_conditions = [];
		if( 'unassigned' === $group_filter)
			$group_conditions = [
				'group_id NOT IN' => $Assignments->find()->select(['group_id'])
			];

		$groups = $this->Jobs->Groups->find('list', [
			'valueField' => function($e) {
				return __('{0} - {1} member(s)', [$e->get('title'), $e->get('member_count')] );
			},
			'conditions' => $group_conditions,
			'order' => [
				'member_count' => 'ASC'
			]
		]);

		$this->set( compact('jobs', 'groups', 'group_filter', 'job_filter') );
	}


	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index() {

		$this->paginate = [
			'contain' => [
				'Todos' => ['Users']
			]
		];

		$jobs = $this->paginate($this->Jobs);

		$this->set(compact('jobs'));
		$this->set('_serialize', ['jobs']);
	}

	public function claim($job_id = null) {

		if( $this->request->is(['put', 'post', 'patch']) ) {
			$job = $this->Jobs->get($job_id, ['contain' => ['SiteLeader']]);
			$job->site_leader = $this->Jobs->SiteLeader->get( $this->Auth->user('user_id') );

			if( $this->Jobs->save($job) ) {
				$this->Flash->success( __('You are now the site leader for {0}', [$job->display_field]) );
			}
		}

		$this->paginate = [
			'conditions' => [
				'site_leader_id' => -1
			],
			'order' => [
				'job_id' => 'ASC'
			],
			'contain' => [
				'SiteLeader'
			]
		];

		$jobs = $this->paginate($this->Jobs);

		$this->set(compact('jobs'));
		$this->set('_serialize', ['jobs']);
	}

	public function me() {
		$me = $this->Jobs->Users->get( $this->Auth->user('user_id'), [
			'contain' => ['Jobs']
		] );

		$this->set(compact('me') );
	}

	public function report() {
		$jobs = $this->Jobs->find('all', [
			'contain' => ['SiteLeader'],
			'order' => [
				'site_leader_id' => 'ASC',
				'contact_last_name' => 'ASC'
			]
		]);


		$this->set( compact('jobs') );
	}

	public function todo($job_id, $user_id) {

		$Todo = TableRegistry::get("Todos");

		$Todo->updateAll(
			[
				'user_id' => $user_id
			],
			[
				'model' => 'Jobs',
				'model_id' => $job_id
			]
		);

		$todos = $Todo->query()
			->where(['model' => 'Jobs', 'model_id' => $job_id]);

		$this->set([
			'todos' => $todos,
			'_serialize' => ['todos']
		]);
	}

	public function leader($job_id, $site_leader_id) {

		$job = $this->Jobs->get($job_id);

		$job->site_leader_id = $site_leader_id;

		$result = $this->Jobs->save($job);

		$this->set([
			'result' => $result,
			'job' => $job,
			'_serialize' => ['job', 'result']
		]);
	}

	public function meta($job_id, $meta_key = null, $meta_value = null ) {
		$meta = null;

		if( $this->request->is(['put', 'post']) ) {
			if( is_null($meta_value) && is_null($meta_key) ) {
				$meta = $this->post_meta($job_id, null, $this->request->input('json_decode') );
			} else {
				$meta = $this->post_meta($job_id, $meta_key, $meta_value);
			}
		} else if( $this->request->is(['patch']) ) {
			throw new Exception("Not implemented.");
		} else if ($this->request->is(['get']) ) {
			$meta = $this->get_meta($job_id, $meta_key);
		} else if( $this->request->is(['delete']) ) {
			// delete when job_id and meta_key are set
		}

		$this->set([
			'meta' => $meta,
			'_serialize' => ['meta']
		]);

	}

	private function get_meta($job_id, $meta_key) {
		$Meta = TableRegistry::get('Meta');

		return $Meta->find('list', [
				'keyField' => 'meta_id',
				'valueField' => 'meta_value'
			])
			->where([
				'model' => 'Jobs',
				'model_id' => $job_id,
				'meta_key' => $meta_key
			]);
	}

	private function post_meta($job_id, $meta_key, $meta_value) {

		$Meta = TableRegistry::get('Meta');
		$stubs = [];

		if( is_null($meta_key) && is_array($meta_value) ) {
			foreach($meta_value as $m) {
				$stubs[] = $Meta->newEntity([
					'model' => 'Jobs',
					'model_id' => $job_id,
					'meta_key' => $m->meta_key,
					'meta_value' => $m->meta_value
				]);
			}
		} else {
			$stubs[] = $Meta->newEntity([
				'model' => 'Jobs',
				'model_id' => $job_id,
				'meta_key' => $meta_key,
				'meta_value' => $meta_value,
			]);
		}

		$Meta->saveMany($stubs);

		return $stubs;

	}

	private function patch_meta($job_id, $meta_key) {
		// use post body to patch
	}
		


	public function map() {
		$User = TableRegistry::get('Users');
		$leaders = $User->find('list')
			->where([
				'role IN' => ['committee', 'admin']
			]);

		$jobs = $this->Jobs->find()
			->contain([
				'Meta',
				'Todos'
			])
			->select([
'job_id', 'contact_first_name', 'contact_last_name', 'contact_phone', 'contact_address_1', 'contact_address_2', 'contact_city', 'contact_state', 'contact_zip', 'site_leader_id']);

		$this->set( compact('jobs', 'leaders') );
	}

	public function note($job_id) {
		$job = null;
		$result = null;

		if( $this->request->is(['put', 'post'])) {
			$job = $this->Jobs->get($job_id);

			if( $job ) {
				$newNotes = sprintf("%s: %s",
					$this->Auth->user('username'),
					$this->request->getData('note')
				);
				$job->notes = trim($job->notes . "\n\n" . $newNotes);

				$result = $this->Jobs->save($job);
			}
		}
		
		$this->set('job', $job);
		$this->set('_serialize', ['job']);
	}

	public function printing($site_leader_id = 'all'){

		$conditions = [
                        'order' => [
                                'site_leader_id' => 'ASC'
                        ],
                        'contain' => [
                                'SiteLeader',
                                'Tools',
                                'Conditions' => [
                                        'conditions' => ['Conditions.condition_id' => 11]
                                ]
                        ],
                        'conditions' => []
                ];

		if( 'all' == $site_leader_id ) {

		} else {
			$conditions['conditions']['Jobs.site_leader_id'] = $site_leader_id;
		}
		
		$jobs = $this->Jobs->find('all', $conditions);

		$this->set(compact('jobs'));
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
			'contain' => [
				'Tasks', 'Todos' => ['Users']]
		]);

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

			$job = $this->Jobs->patchEntity($job, $this->request->getData());
			$job->notes = "";
			if (($result = $this->Jobs->save($job)) && $result) {

				//$candidate_user = $this->getLeastBusyUser();
				$candidate_user = 795; // this is Richard LMAO

				$todos = [];

				foreach( $templates->find('all') as $todoTemplate ) {
					array_push(	$todos, $Todos->newEntity([
							'model' => 'Jobs',
							'model_id' => $result->job_id,
							'user_id' => 2,
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
				$this->getEventManager()->dispatch($evt);

				$this->Flash->success(__('Your job has been submitted. Please check your email for confirmation.'));
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
			'contain' => [
				'Tasks', 
				'Conditions', 
				'Tools', 
				'Groups'
			]
		]);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$data = $this->request->getData();
			$data['tools'] = array_filter($data['tools'], function($tool) {
				return intval($tool['_joinData']['count']) > 0;
			});



			$job = $this->Jobs->patchEntity($job, $data, [
				'associated' => [
					'SiteLeader',
					'Conditions',
					'Tools',
					'Tasks',
					'Tools._joinData'
				]
			]);

			if( $job->site_leader_id == null )
				$job->site_leader_id = -1;

			if ($this->Jobs->save($job)) {

				$event = new Event('Job.Modified', $this, [
					'job_id' => $job->job_id
				]);
				$this->eventManager()->dispatch($event);

				$this->Flash->success(__('The job has been saved.'));
				return $this->redirect(['action' => 'edit', $job->job_id]);
			} else {
				$this->Flash->error(__('The job could not be saved. Please, try again.'));
			}
		}

		$conditions = [];
		if( $job->tools ) {
			$conditions = [
				'tool_id NOT IN' => Hash::extract($job->tools, '{n}.tool_id')
			];
		}
		$tools = $this->Jobs->Tools->find('list', [
			'conditions' => $conditions
		]);
		//$jobs = $this->Jobs->Jobs->find('list', ['limit' => 200]);
		$tasks = $this->Jobs->Tasks->find('list', ['limit' => 200]);

		$conditions = $this->Jobs->Conditions->find('list');
		$site_leaders = $this->Jobs->SiteLeader->find('list', [
			'conditions' => [
				'role IN' => ['committee', 'admin']
			]
		]);

		$this->set(compact('job', 'tasks', 'conditions', 'tools', 'site_leaders'));
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
        // if( !strpos($this->request->referer(), $this->request->here) ) {
        // 	$redirect = $this->request->referer();
        // }

        return $this->redirect($redirect);
    }
 }
