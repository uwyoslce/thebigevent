<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('My Todos'), ['controller' => 'todos', 'action' => 'me']); ?></li>
		<li><?= $this->Html->link(__('New Todo'), ['controller' => 'todos', 'action' => 'add']) ?></li>
		<li class="heading"><?= __('Jobs') ?></li>
		<li><?= $this->Html->link(__('Job Listings'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
		<li class="heading"><?= __('Users') ?></li>
		<li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
		<li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
	</ul>
</nav>
<div class="jobs index large-9 medium-8 columns content">
	<h3><?= __('Jobs') ?></h3>
	<?php foreach($jobs as $job) : ?>
		<?php echo $this->element('Cards/Job', ['job'=> $job]); ?>
	<?php endforeach; ?>
	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
		</ul>
		<p><?= $this->Paginator->counter() ?></p>
	</div>
</div>
