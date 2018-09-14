<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 */
class DocumentsController extends AppController
{

	public function isAuthorized( $user ) {

		return parent::isAuthorized( $user ); // TODO: Change the autogenerated stub
	}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    function index()
    {
        $this->paginate = [];
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents'));
        $this->set('_serialize', ['documents']);
    }

    public function view($document_id) {
    	$document = $this->Documents->get($document_id, [
    		'contain' => [
    			'Signatures' => ['Users']
    		]
    	]);

    	if( !$document ) {
    		throw new NotFoundException(__("Document could not be found") );
    	}

    	$this->set( compact('document') );
    }

    public function distribute($document_id) {
	    $Users = TableRegistry::get('Users');

	    $users = $Users->find('all');
	    $document = $this->Documents->get($document_id);

	    if( !$document ) {
	    	throw new NotFoundException(__('Document could not be found') );
	    }

	    $signatures = [];
	    foreach( $users as $user ) {
	    	/*
				Documents can only be signed once by each user.
				This allows for safe "withdrawl"/"distribute"
	    	*/
	    	if( !$this->Documents->Signatures->exists([
	    		'document_id' => $document->document_id,
	    		'user_id' => $user->user_id
	    		])
	    	) {
		    	$signatures[] = $this->Documents->Signatures->newEntity([
		    		'signed' => false,
				    'document_id' => $document->document_id,
				    'user_id' => $user->user_id,
				    'signature_text' => ''
			    ]);
			}
	    }

	    if( $this->Documents->Signatures->saveMany($signatures) ) {
	    	$this->Flash->success(__('Documents assigned to users for signing') );
	    } else {
	    	$this->Flash->error( __('Error assigning Document to users for signing') );
	    }

	    return $this->redirect(['action' => 'index']);

    }

    public function withdraw($document_id) {
    	if( $this->Documents->exists([
    		'document_id' => $document_id
	    ])) {
		    if(
		    	$this->Documents->Signatures->deleteAll([
			        'Signatures.document_id' => $document_id,
			        'Signatures.signed'      => false
		        ])
		    ) {
		    	$this->Flash->success( __('Document {0} successfully withdrawn', [$document_id]) );
		    }
	    }

	    return $this->redirect(['action' => 'index']);
    }

	public function upload() {

		$allowed_mimes = [
			'application/pdf',
			'image/jpg',
			'image/png',
			'image/jpeg'
		];

		if( $this->request->is( ['put', 'post', 'patch'] ) ) {
			debug($this->request->getData());
			$data = $this->request->getData();
			if( in_array($data['document']['type'], $allowed_mimes) ) {
				$dest = 'docs' . DS . trim( str_replace(' ', '_', $data['document']['name'] ) );

				$move = move_uploaded_file(
					$data['document']['tmp_name'],
					WWW_ROOT . $dest
				);

				$document = $this->Documents->newEntity([
					'title' => $data['title'],
					'path'  => DS . $dest,
					'type' => $data['document']['type']
				]);

				if( $move && $this->Documents->save($document) ) {
					$this->Flash->success( __('Document successfully uploaded') );
				} else {
					$this->Flash->error( __('There was a problem uploading the document') );
				}
			} else {
				$this->Flash->error( __('You may only upload PDF, JPG and PNG documents.') );
			}

			return $this->redirect(['action' => 'index']);
		}
	}

	public function download() {

	}

	public function delete($document_id) {
		if( $this->request->is( ['delete', 'post'] ) ) {

			$document = $this->Documents->get( $document_id );

			if ( ! $document ) {
				throw new NotFoundException( __( 'The specified document could not be found' ) );
			}

			$file = new File( $document->path, false );

			if ( $file->delete() &&
			     $this->Documents->delete( $document )
			) {
				$this->Flash->success( __( 'Document successfully deleted' ) );
			} else {
				if ( $file->exists() ) {
					$this->Flash->error( __( 'Could not delete document from disk.  Check permissions?' ) );
				} else {
					$this->Documents->delete( $document );
				}
			}
		}

		return $this->redirect(['action' => 'index']);
	}
}
