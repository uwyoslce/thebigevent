<div class="column large-3">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</div>
<div class="column large-9 content">
	<h1>Create a Group</h1>

	<?= $this->Form->create('Group') ?>

	<?= $this->Form->control('title'); ?>

	<?= $this->Form->button('Create New Group'); ?>
	<?= $this->Form->end(); ?>

</div>