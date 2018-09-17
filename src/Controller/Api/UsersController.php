<?php

namespace App\Controller\Api;

class UsersController extends AppController
{
	/**
	 * Get users (paginated)
	 * query: finder	a finder query to use to create the list
	 * GET /users/
	 */
	public function users() {
		$finder = $this->request->getQuery('finder', 'all');
		if( in_array($finder, ['all', 'leaders', 'volunteers']) ) {
			$query = $this->Users->find($finder);
			$this->set('users', $this->paginate($query));
			$this->set('paging', $this->getPaging('Users'));
			$this->set('_serialize', ['users', 'paging']);
		}
	}

	/**
	 * Get a user by username. If username is null, the current user is returned
	 * GET /users/me
	 * GET /users/:username
	 */
	public function user($username = null)
	{
		if( !$username ) {
			$username = $this->Auth->user('username');
		}

		$user = $this->Users->findByUsername($username)->first();

		if( !$user ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find User $username.");
		}

		$this->set('user', $user);
		$this->set('_serialize', ['user']);
	}

	/**
	 * Get a User's groups.  If username is null, groups for the current user are returned
	 * GET /users/me/groups
	 * GET /users/:username/groups
	 */
	public function userGroups($username = null)
	{
		if( !$username ) {
			$username = $this->Auth->user('username');
		}

		$user = $this->Users->find('all', [
			'conditions' => ['username' => $username],
			'contain' => ['Groups']
		])->first();

		if( !$user ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find User $username or any groups.");
		}

		$this->set('groups', $user->groups);
		$this->set('_serialize', ['groups']);
	}

	/**
	 * Assign a user to the posted Group stub
	 * PUTorPOST /users/me/groups
	 * PUTorPOST /users/:username/groups
	 */
	public function userGroupsAssign($username = null)
	{
		if( !$username ) {
			$username = $this->Auth->user('username');
		}
	}

	/**
	 * Get a User's signatures
	 * GET /users/me/signatures
	 * GET /users/:username/signatures
	 */
	public function userSignatures($username = null)
	{
		if( !$username ) {
			$username = $this->Auth->user('username');
		}
		
		$user = $this->Users->findByUsername($username)->first();
		if( !$user ) {
			throw new \Cake\Network\Exception\NotFoundException(
				"Unable to find User $username or any Signatures for signing.");
		}

		$signatures_query = $this->Users->Signatures->findByUserId($user->user_id);
		$signatures = $this->paginate( $signatures_query );
		if( !$signatures ) {
			throw new \Cake\Network\Exception\NotFoundException(
				"Unable to find User $username or any Signatures for signing.");
		}

		$this->set('signatures', $signatures);
		$this->set('paging', $this->getPaging('Signatures') );
		$this->set('_serialize', ['signatures', 'paging']);
	}

	/**
	 * Get a User's Todos. If $username is null, todos for the current user are returned.
	 * GET /users/me/todos
	 * GET /users/:username/todos
	 */
	public function userTodos($username = null)
	{
		if( !$username ) {
			$username = $this->Auth->user('username');
		}
		
		$user = $this->Users->findByUsername($username)->first();
		if( !$user ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find User $username or any todo items.");
		}

		$todos_query = $this->Users->Todos->findByUserId($user->user_id);
		$todos = $this->paginate( $todos_query );
		if( !$todos ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find User $username or any todo items.");
		}

		$this->set('todos', $todos);
		$this->set('paging', $this->getPaging("Todos") );
		$this->set('_serialize', ['todos', 'paging']);
	}
}