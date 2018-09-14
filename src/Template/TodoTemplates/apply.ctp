<div class="large-3 columns">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</div>
<div class="large-9 columns content">
	<h1><?= __('Apply Todo Templates'); ?></h1>
	<?php echo $this->Form->create('Todos'); ?>
	<?php
		echo $this->Html->tag('p', __('Select the object type that you want to apply todos to') );
		echo $this->Form->select('model', $allowed_models);

		echo $this->Form->select('date_calculation', [
			'created' => "Relative to Model.created",
			'now' => "Relative to now"
		]);
		echo $this->Form->select('spread', [
			'group' => "Group by model.model_id",
			'random' => "Assign at random"
		]);
		echo $this->Form->button('Apply Todo Templates');
	?>
	<?php echo $this->Form->end(); ?>
</div>