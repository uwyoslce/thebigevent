
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>

		<li><?= $this->Html->link(
				__('Edit Condition'),
				['action' => 'edit', $condition->condition_id]
			)
			?></li>
		<li><?= $this->Html->link(
				__('View All Conditions'),
				['action' => 'index']
			); ?></li>

	</ul>
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</nav>
<section class="large-9 columns content">
	<h2><?= h($condition->title) ?></h2>
	<?php if( $condition->has('jobs') ): ?>
	<h3><?= __('Jobs With This Condition') ?></h3>
		<ul>
		<?php foreach($condition->jobs as $job) : ?>
			<li><?= $this->Html->link( $job->display_field, ['controller' => 'jobs', 'action' => 'view', $job->job_id] ); ?></li>
		<?php endforeach; ?>
			</ul>
	<?php endif; ?>
</section>