<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>

		<li><?= $this->Html->link(
				__('View Condition Details'),
				['action' => 'view', $condition->condition_id]
			)
			?></li>
		<li><?= $this->Html->link(
				__('View All Conditions'),
		        ['action' => 'index']
			); ?></li>

	</ul>
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</nav>
<section class="large-9 medium-8 columns content">

<?= $this->Form->create($condition); ?>
	<?= $this->Form->control('title'); ?>
	<?= $this->Form->button('Edit Condition'); ?>
<?= $this->Form->end(); ?>
</section>