<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

define('NUMERIC', '[0-9]+');
define('SLUG', '[A-Za-z0-9_]+');
define('USERNAME', '[A-Za-z0-9_]{3,}');

Router::prefix('api', function( RouteBuilder $routes) {

	function name($name) {
		return [
			'_name' => 'api' . $name
		];
	}

	$routes->setExtensions(['json']);

	$routes->connect('/users/login', ['controller' => 'Users', 'action' => 'login']);

	// $routes
	// 	->connect('/*', ['controller' => 'App', 'action' => 'cors'])
	// 	->setMethods(['OPTIONS']);

	// Scope: Jobs
	$routes->scope('/jobs', function($routes) {
		//$routes->get('', ['controller' => 'Jobs', 'action' => 'jobs']);
		//$routes->put('', ['controller' => 'Jobs', 'action' => 'jobs_create']);

		$routes
			->connect('', ['controller' => 'Jobs', 'action' => 'jobs'], name('GetAllJobs'))
			->setMethods(['GET']);
		$routes
			->connect('', ['controller' => 'Jobs', 'action' => 'jobs_create'], name('CreateJob'))
			->setMethods(['PUT', 'POST']);

		$routes->scope('/:job_id', function($routes) {
			// GET /jobs/:job_id
			$routes 
				->connect('', ['controller' => 'Jobs', 'action' => 'job'], name('GetJob'))
				->setMethods(['GET'])
				->setPass(['job_id'])
				->setPatterns([
					'job_id' => NUMERIC
				]);
			
			// PATCH /jobs/:job_id
			$routes
				->connect('', ['controller' => 'Jobs', 'action' => 'job_update'], name('UpdateJob'))
				->setMethods(['PATCH'])
				->setPass(['job_id'])
				->setPatterns([
					'job_id' => NUMERIC
				]);
			
			// DELETE /jobs/:job_id => JobsController->jobDelete($job_id)
			$routes 
				->connect('', ['controller' => 'Jobs', 'action' => 'job_delete'], name('DeleteJob'))
				->setMethods(['DELETE'])
				->setPass(['job_id'])
				->setPatterns([ 'job_id' => NUMERIC ]);

			
			$routes->scope('/todos', function($routes) {
				// GET /jobs/:job_id/todos => JobsController->jobTodos()
				$routes 
					->connect('', ['controller' => 'Jobs', 'action' => 'job_todos'], name('GetTodosByJob'))
					->setMethods(['GET'])
					->setPass(['job_id'])
					->setPatterns([ 'job_id' => NUMERIC ]);
				
				// PUTorPOST /jobs/:job_id/todos => JobsController->jobTodosCreate()
				$routes 
					->connect('', ['controller' => 'Jobs', 'action' => 'job_todos_create'], name('CreateTodosByJob'))
					->setMethods(['PUT', 'POST'])
					->setPass(['job_id'])
					->setPatterns([ 'job_id' => NUMERIC ]);
				
			});

			// RELATED: Meta
			$routes->scope('/meta', function($routes) {
				
				// GET /jobs/:job_id/meta => JobsController->jobMeta()
				$routes
					->connect('', ['controller' => 'Jobs', 'action' => 'job_meta'], name('GetMetaByJob'))
					->setMethods(['GET'])
					->setPass(['job_id'])
					->setPatterns([ 'job_id' => NUMERIC ]);
				//$routes->post('/', ['controller' => 'Jobs', 'action' => 'job_meta_create']);

				// GET /jobs/:job_id/meta/:meta_key => JobsController->jobMetaByKey($job_id, $meta_key)
				$routes
					->connect('/:meta_key', ['controller' => 'Jobs', 'action' => 'job_meta_by_key'], name('GetMetaByJobAndKey'))
					->setMethods(['GET'])
					->setPass(['job_id', 'meta_key'])
					->setPatterns([
						'job_id' => NUMERIC,
						'meta_key' => SLUG
					]);
			});

			// RELATED: Group(s)
			$routes->scope('/groups', function($routes) {
				// GET /jobs/:job_id/groups => JobsController->jobGroups($job_id)1
				$routes
					->connect('', ['controller' => 'Jobs', 'action' => 'job_groups'], name('GetGroupsByJob'))
					->setMethods(['GET'])
					->setPass(['job_id'])
					->setPatterns(['job_id' => NUMERIC]);

				// PUT /jobs/:job_id/groups => JobsController->job_groups_assign($job_id)
				$routes
					->connect('/', ['controller' => 'Jobs', 'action' => 'job_groups_assign'], name('AssignGroupsByJob'))
					->setMethods(['PUT'])
					->setPass(['job_id'])
					->setPatterns(['job_id' => NUMERIC]);
			});
		});
	});

	// Scope: Users
	$routes->scope('/users', function($routes) {
		$routes->redirect('/login', [ 'controller' => 'Users', 'action' => 'login']);

		$routes
			->connect('/leaders', ['controller' => 'Users', 'action' => 'leaders'])
			->setMethods(['GET']);

		$routes->scope('/me', function($routes) {
			// User
			// GET /api/users/me
			$routes
				->connect('', ['controller' => 'Users', 'action' => 'user', 'username' => NULL], name('GetMe'))
				->setMethods(['GET'])
				->setPass(['username']);

			// Group
			// GET /api/users/me/groups
			$routes
				->connect('/groups', ['controller' => 'Users', 'action' => 'user_groups', 'username' => NULL], name('GetMyGroups'))
				->setMethods(['GET'])
				->setPass(['username']);
			$routes
				->connect('/groups', ['controller' => 'Users', 'action' => 'user_groups_assign', 'username' => NULL], name('AssignGroupsToMe'))
				->setMethods(['PUT', 'POST'])
				->setPass(['username']);

			// Signatures
			// GET /api/users/me/signatures
			$routes
				->connect('/signatures', ['controller' => 'Users', 'action' => 'user_signatures', 'username' => NULL], name('GetMySignatures'))
				->setMethods(['GET'])
				->setPass(['username']);

			// Todos
			// GET /api/users/me/todos
			$routes
				->connect('/todos', ['controller' => 'Users', 'action' => 'user_todos', 'username' => NULL], name('GetMyTodos'))
				->setMethods(['GET'])
				->setPass(['username']);
		});

		$routes->scope('/:username', function($routes) {
			$routes
				->connect('', ['controller' => 'Users', 'action' => 'user'], name('GetUser') )
				->setMethods(['GET'])
				->setPass(['username'])
				->setPatterns(['username' => USERNAME]);

			// Group
			// GET /api/users/me/groups
			$routes
				->connect('/groups', ['controller' => 'Users', 'action' => 'user_groups'], name('GetGroupsByUser'))
				->setMethods(['GET'])
				->setPass(['username'])
				->setPatterns(['username' => USERNAME]);
			$routes
				->connect('/groups', ['controller' => 'Users', 'action' => 'user_groups_assign'], name('AssignGroupsByUser'))
				->setMethods(['PUT', 'POST'])
				->setPass(['username'])
				->setPatterns(['username' => USERNAME]);

			// Signatures
			// GET /api/users/me/signatures
			$routes
				->connect('/signatures', ['controller' => 'Users', 'action' => 'user_signatures'], name('GetSignaturesByUser'))
				->setMethods(['GET'])
				->setPass(['username'])
				->setPatterns(['username' => USERNAME]);

			// Todos
			// GET /api/users/me/todos
			$routes
				->connect('/todos', ['controller' => 'Users', 'action' => 'user_todos'], name('GetTodosByUser'))
				->setMethods(['GET'])
				->setPass(['username'])
				->setPatterns(['username' => USERNAME]);
		});
	});

	// Scope: Documents
	$routes->scope('/documents', function($routes) {
		// GET /api/documents => DocumentsController->documents();
		$routes
			->connect('', ['controller' => 'Documents', 'action' => 'documents'], name("GetDocuments"))
			->setMethods(['GET']);
		
		$routes->scope('/:document_id', function($routes) {
			// GET /api/documents/:document_id
			$routes
				->connect('', ['controller' => 'Documents', 'action' => 'document'], name('GetDocument') )
				->setMethods(['GET'])
				->setPass(['document_id'])
				->setPatterns(['document_id' => NUMERIC]);
			
			// GET /api/documents/:document_id/signatures
			$routes
				->connect('/signatures', ['controller' => 'Documents', 'action' => 'document_signatures'], name('GetSignaturesByDocument'))
				->setMethods(['GET'])
				->setPass(['document_id'])
				->setPatterns(['document_id' => NUMERIC]);
			
		});
	});

	// Scope: Todos
	$routes->scope('/todos', function($routes){
		$routes
			->connect('', ['controller' => 'Todos', 'action' => 'todos'], name('GetTodos'))
			->setMethods(['GET']);
		
		$routes
			->connect('/:todo_id', ['controller' => 'Todos', 'action' => 'todo'], name('GetTodo'))
			->setMethods(['GET'])
			->setPass(['todo_id'])
			->setPatterns(['todo_id' => NUMERIC]);

		$routes
			->connect('/:todo_id/user', ['controller' => 'Todos', 'action' => 'todo_user'], name('GetTodoUser') )
			->setMethods(['GET'])
			->setPass(['todo_id'])
			->setPatterns(['todo_id' => NUMERIC]);

		$routes
			->connect('/:todo_id/related', ['controller' => 'Todos', 'action' => 'todo_related'], name('GetTodoRelatedModel') )
			->setMethods(['GET'])
			->setPass(['todo_id'])
			->setPatterns(['todo_id' => NUMERIC]);
	});
});
