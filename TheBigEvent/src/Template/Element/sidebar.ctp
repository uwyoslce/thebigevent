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