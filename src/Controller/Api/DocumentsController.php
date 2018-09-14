<?php
namespace App\Controller\Api;

class DocumentsController extends AppController
{
    /**
     * Get all documents (paginated)
     * GET /api/documents
     */
    public function documents() {
        $query = $this->paginate($this->Documents);
        $this->set('documents', $query);
		$this->set('paging', $this->getPaging('Documents') );
        $this->set('_serialize', ['documents', 'paging']);
    }

    /**
     * Get a document
     * GET /api/documents/:document_id
     */
	public function document($document_id = null) {
        $document = $this->Documents->findByDocumentId($document_id)->first();

        if( !$document ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find Document with id $document_id.");
        }

        $this->set('document', $document);
        $this->set('_serialize', ['document']);
    }

    /**
     * Get a document's signatures (paginated)
     * GET /api/documents/:document_id/signatures
     */
    public function documentSignatures($document_id = null) {
        $query = $this->Documents->Signatures->findByDocumentId($document_id);
        
        if( $query->count() == 0 ) {
			throw new \Cake\Network\Exception\NotFoundException("Unable to find Document with id $document_id.");
        }

        $this->set('signatures', $this->paginate( $query ));
		$this->set('paging', $this->getPaging('Signatures') );
        $this->set('_serialize', ['signatures', 'paging']);
    }
}