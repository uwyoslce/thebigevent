<aside class="large-3 columns">

	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</aside>
<article class="large-9 columns content">

	<h1><?= __( 'Upload a Document' ) ?></h1>
	<p><?= __( 'Use this form to upload a document.  Once a document is uploaded, you can distribute it to users for electronic signing.' ) ?></p>

	<?php echo $this->Form->create( 'Documents', [ 'type' => 'file' ] ); ?>
	<?php echo $this->Form->control( 'title' ); ?>
	<?php echo $this->Form->control( 'document', [
		'type'  => 'file',
		'label' => 'Select File'
	] ); ?>
	<?php echo $this->Form->button( 'Upload Document' ); ?>
	<?php echo $this->Form->end() ?>
</article>