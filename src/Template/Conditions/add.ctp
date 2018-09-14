<div class="column large-3">

</div>
<div class="column large-9">

	<?php echo $this->Form->create('Condition'); ?>
	<h2><?= h(__("Create New Condition") ) ?></h2>
	<?php echo $this->Form->control('title'); ?>

	<?php echo $this->Form->button(__("Add New Condition") ); ?>
	<?php echo $this->Form->end(); ?>
</div>