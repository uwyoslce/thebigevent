<?php

namespace App\Controller\Api;

use Cake\Utility\Inflector;

class JobsController extends AppController {

	public function cors() {
		if ($this->request->is('OPTIONS')) {
			$this->setCorsHeaders();
			return $this->response;
		}
	}
	
	/**
	 * Get an array of jobs.
	 * GET /api/jobs/
	 */
	public function jobs() {
		$contain = [];
		if( null !== $this->request->getQuery('include') ) {
			$models = explode(',', $this->request->getQuery('include') );

			foreach( $models as $model ) {
				$inflectedModel = Inflector::camelize( $model );
				if( in_array($inflectedModel, [
					'SiteLeader', 
					'Meta',
					'Tasks',
					'Todos',
					'Conditions',
					'Tools',
					'Groups',
				] ) ){
					array_push($contain, $inflectedModel );
				}
			}
		}
		
		$jobs_query = $this->Jobs->find('all', [
			'contain' => $contain
		]);
		$jobs_count = $jobs_query->count();

		$this->set('jobs', $this->paginate($jobs_query) );
		$this->set('paging', $this->getPaging('Jobs') );
		$this->set('_serialize', ['jobs', 'paging']);
	}

	/**
	 * Create a new job.
	 * PUT/PATCH to /api/:version/jobs/
	 */
	public function jobsCreate() {
		// sets new Job at _.job
		$job = $this->Jobs->newEntity( (array) $this->request->input('json_decode') );

		if( $this->Jobs->save($job) ) {
			$this->set('success', true);
		} else {
			$this->set('success', false);
			$this->set('errors', $job->errors() );
		}
		$this->set('job', $job);
		$this->set('_serialize', ['job', 'success', 'errors']);
	}

	/**
	 * Get a Job
	 * GET /api/jobs/:job_id
	 */
	public function job($job_id = null) {
		$job = $this->Jobs->findByJobId($job_id)->first();
		if( !$job ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find Job $job_id");
		}
		$this->set('job', $job);
		$this->set('_serialize', ['job']);
	}

	/**
	 * Change a Job's details
	 * PATCH /api/jobs/:job_id
	 */
	public function jobUpdate($job_id = null) {
		$job = $this->Jobs->findByJobId($job_id)->first();

		if( !$job ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find Job $job_id");
		}

		$this->Jobs->patchEntity( $job, (array) $this->request->input('json_decode') );

		$this->set('job', $this->Jobs->save($job) );
		$this->set('_serialize', ['job']);
	}

	/**
	 * Delete a Job
	 * DELETE /api/jobs/:job_id
	 */
	public function jobDelete($job_id = null) {
		$job = $this->Jobs->findByJobId($job_id)->first();

		if( !$job ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find Job $job_id");
		}

		$this->set('success', $this->Jobs->delete($job) );
		$this->set('_serialize', ['success']);
	}

	/**
	 * Get a Job's metadata
	 * GET /api/jobs/:job_id/meta
	 */
	public function jobMeta($job_id) {
		$meta_query = $this->Jobs->Meta->find('all', [
			'conditions' => [
				'model' => 'Jobs',
				'model_id' => $job_id
			]
		]);

		$this->set('meta', $this->paginate($meta_query) );
		$this->set('paging', $this->getPaging("Meta") );
		$this->set('_serialize', ['meta', 'paging']);

	}

	/**
	 * Get a Job's metadata by key
	 * GET /api/jobs/:job_id/meta/:meta_key
	 */
	public function jobMetaByKey($job_id = null, $meta_key = null) {
		$meta_query = $this->Jobs->Meta->find('all', [
			'conditions' => [
				'model' => 'Jobs',
				'model_id' => $job_id,
				'meta_key' => $meta_key
			]
		]);

		$this->set('meta', $this->paginate($meta_query) );
		$this->set('paging', $this->getPaging("Meta") );
		$this->set('_serialize', ['meta', 'paging']);
	}

	/**
	 * Get a Job's list of Todo items
	 * GET /api/jobs/:job_id/todos
	 */
	public function jobTodos($job_id = null) {
		$todos_query = $this->Jobs->Todos->find('all', [
			'conditions' => [
				'model' => 'Jobs',
				'model_id' => $job_id
			]
		]);
		$this->set('todos', $this->paginate($todos_query) );
		$this->set('paging', $this->getPaging("Todos") );
		$this->set('_serialize', ['todos', 'paging']);
	}

	/**
	 * Create a Todo under a job
	 * PUT /api/jobs/:job_id/todos
	 */
	public function jobTodosCreate() {

	}

	/**
	 * Get all Groups assigned to work at Job
	 * GET /api/jobs/:job_id/groups
	 */
	public function jobGroups($job_id = null) {
		$job = $this->Jobs->find('all', [
			'conditions' => [ 'job_id' => $job_id ],
			'contain' => [ 'Groups' ]
		])->first();

		if( !$job ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find Job $job_id. Try assigning the Group to the Job first.");
		}

		$this->set([
			'groups' => $job->groups
		]);
		$this->set('_serialize', ['groups']);
	}

	/**
	 * Assign groups to work at Job
	 */
	public function jobGroupsAssign() {
		$job_id = $this->request->getParam('job_id');
	}
}