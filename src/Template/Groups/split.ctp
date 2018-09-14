<aside class="columns large-3">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</aside>
<main class="columns large-9 content">
<?php echo $this->Form->create(null); ?>
	<h2><?= __('Split Groups') ?></h2>
	<p><?php $sentences = [
	__('Split one group into many groups.'),
	__('Specify the group, and then how many resulting groups you want.'),
	__('Or specify the target size for the resulting groups.')
	];
	echo implode(' ', $sentences);
	 ?></p>

	<?php echo $this->Form->control('group_id', ['options' => $groups, 'label' => "Group"]); ?>
	<?php echo $this->Form->control('pieces', ['label' => "Number of Resulting Groups", 'type' => 'number']); ?>
	<?php echo $this->Form->control('target_size', ['label' => "OR Target Group Size", 'type' => 'number']); ?>

	<?php echo $this->Form->button('Split'); ?>

<?php echo $this->Form->end(); ?>
</main>