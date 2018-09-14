<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TodoTemplates Controller
 *
 * @property \App\Model\Table\TodoTemplatesTable $TodoTemplates
 */
class TodoTemplatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        ];
        $todosTemplates = $this->paginate($this->TodoTemplates);

        $this->set(compact('todosTemplates'));
        $this->set('_serialize', ['todosTemplates']);
    }

    /**
     * View method
     *
     * @param string|null $id Todos Template id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $todosTemplate = $this->TodoTemplates->get($id, [
            'contain' => ['TodoTemplates']
        ]);

        $this->set('todosTemplate', $todosTemplate);
        $this->set('_serialize', ['todosTemplate']);
    }

    public function apply($job_id = null) {

    	$allowed_models = ['Jobs'];

    	if( 'admin' == $this->Auth->user('role' ) )
		if( $this->request->is(['put', 'post', 'patch']) ) {
    		$TodoTemplates = $this->TodoTemplates->find('all');
			$Todo = \Cake\ORM\TableRegistry::get('Todos');
			$Job = \Cake\ORM\TableRegistry::get('Jobs');


			$Jobs = $Job->find('all');
			$results = [];

			foreach($Jobs as $job) {
				$todos = [];
				$user = $this->getLeastBusyUser();
				foreach($TodoTemplates as $todoTemplate) {
					$todos[] =$Todo->newEntity([
						'model' => 'Jobs',
						'model_id' =>$job->job_id,
						'user_id' => $user->user_id,
						'description' => $todoTemplate->description,
						'long_description' => $todoTemplate->long_description,
						'due' => $job->created->modify($todoTemplate->due_description),
						'completed' => false
					]);
				}
				$results[] = $Todo->saveMany($todos);
			}

		}

	    $this->set( compact('allowed_models') );
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $todosTemplate = $this->TodoTemplates->newEntity();
        if ($this->request->is('post')) {
            $todosTemplate = $this->TodoTemplates->patchEntity($todosTemplate, $this->request->getData());
            if ($this->TodoTemplates->save($todosTemplate)) {
                $this->Flash->success(__('The todos template has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The todos template could not be saved. Please, try again.'));
            }
        }
        $todoTemplates = $this->TodoTemplates->TodoTemplates->find('list', ['limit' => 200]);
        $this->set(compact('todosTemplate', 'todoTemplates'));
        $this->set('_serialize', ['todosTemplate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Todos Template id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $todosTemplate = $this->TodoTemplates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $todosTemplate = $this->TodoTemplates->patchEntity($todosTemplate, $this->request->getData());
            if ($this->TodoTemplates->save($todosTemplate)) {
                $this->Flash->success(__('The todos template has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The todos template could not be saved. Please, try again.'));
            }
        }
        $todoTemplates = $this->TodoTemplates->TodoTemplates->find('list', ['limit' => 200]);
        $this->set(compact('todosTemplate', 'todoTemplates'));
        $this->set('_serialize', ['todosTemplate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Todos Template id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $todosTemplate = $this->TodoTemplates->get($id);
        if ($this->TodoTemplates->delete($todosTemplate)) {
            $this->Flash->success(__('The todos template has been deleted.'));
        } else {
            $this->Flash->error(__('The todos template could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
