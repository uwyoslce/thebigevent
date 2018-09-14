<?php
namespace App\Controller\Api;

use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Routing\Router;

class TodosController extends AppController
{
    /**
     * Get all todos (paginated)
     * GET /api/todos/
     */
	public function todos() {
        $todo_query = $this->Todos->find();
        $this->set('todos', $this->paginate($todo_query));
        $this->set('todos_count', $todo_query->count() );
        $this->set('_serialize', ['todos', 'todos_count']);
    }

    /**
     * Get a todo
     * GET /api/todos/:todo_id
     */
    public function todo($todo_id = null) {
        $this->set('todo', $this->Todos->findByTodoId($todo_id)->first());
        $this->set('_serialize', ['todo']);
    }

    /**
     * Get a Todo's user
     * GET/api/todos/:todo_id/user
     */
    public function todoUser($todo_id = null) {
        $todo = $this->Todos->find('all', [
            'conditions' => ['todo_id' => $todo_id],
            'contain' => ['Users']
        ])->first();

        if( !$todo ) {
            throw new \Cake\Network\Exception\NotFoundException("Unable to find Todo with id $todo_id.");
        }

        $this->set('user', $todo->user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Returns the entity row that's related to the todo.
     * GET /api/todos/:todo_id/related
     */
    public function todoRelated($todo_id = null) {
        $todo = $this->Todos->findByTodoId($todo_id)->first();
        if( !$todo ) {
            throw new \Cake\Network\Exception\NotFoundException("Unable to find Todo with id $todo_id.");
        }

        $table = TableRegistry::get($todo->model);
        if( !$table ) {
            throw new \Cake\Network\Exception\NotFoundException("Unable to find related entity $todo->model.");
        }
        $row = $table->find('all', [
            'conditions' => [
                "".$table->getPrimaryKey() => $todo->model_id
            ]
        ])->first();

        if( !$row ) {
            throw new \Cake\Network\Exception\NotFoundException("Unable to find related row $todo->model_id.");
        }

        $singularModel = strtolower( Inflector::singularize($todo->model) );

        $this->set('model', $singularModel);
        // $this->set('url', Router::url([
        //     'controller' => $todo->model,
        //     'action' => $singularModel,
        //     $table->getPrimaryKey() => $todo->model_id
        // ]));
        $this->set($singularModel, $row);
        $this->set('_serialize', ['model', $singularModel]);

    }
}