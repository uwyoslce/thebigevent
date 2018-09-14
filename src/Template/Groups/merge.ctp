<aside class="columns large-3">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</aside>
<main class="columns large-9 content">
<?php echo $this->Form->create(null); ?>
	<h2><?= __('Merge Groups') ?></h2>
	<p><?php $sentences = [
	__('Combine two groups into one group.'),
	__('The Disappearing group will be deleted and the Surviving group will get all of the Disappearing group members.'),
	__('You can rename the Surviving group if you want.')
	];
	echo implode(' ', $sentences);
	 ?></p>

	<?php echo $this->Form->control('left_group_id', ['options' => $groups, 'label' => "Surviving Group"]); ?>

	<?php echo $this->Form->control('right_group_id', ['options' => $groups, 'label' => "Disappearing Group"]); ?>
	<?php echo $this->Form->control('title', ['label' => "Rename Surviving Group (optional)"]); ?>

	<?php echo $this->Form->button('Merge'); ?>

<?php echo $this->Form->end(); ?>
</main>