<div class="column large-3">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</div>
<div class="column large-9 content">
	<h1>Join a Group</h1>

	<?= $this->Form->create('Group') ?>
	<p>
		A group leader may have given you a token that will allow you to join their group.
		Enter that token here.</p>
	<p>
		You can only belong to one group.
		If you are already a member of a group, you will leave that group to join the new group.
	</p>

	<?= $this->Form->control('join_token'); ?>

	<?= $this->Form->button('Join Group'); ?>

	<?= $this->Form->end(); ?>

</div>