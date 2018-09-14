	<ul class="side-nav no-print">

		<?php if( $user_role ) : ?>

			<?php if( in_array($user_role, ['admin', 'committee'] ) ): ?>
			
			<li class="heading"><?= __('Committee') ?></li>

				
				<li><?= $this->Html->link(__('Manage Todos'), ['controller' => 'Todos', 'action' => 'me']); ?></li>
				<li><?= $this->Html->link(__('New Job Request'), ['controller' => 'Jobs', 'action' => 'request']) ?></li>
				<li><?= $this->Html->link(__('Open Slack'), 'https://uwyobigevent.slack.com', ['target' => '_blank']) ?></li>

			<li class="heading"><?= __("Site Leader") ?></li>

				<li><?= $this->Html->link(__('My Sites'), ['controller' => 'Users', 'action' => 'sites']) ?></li>

			<li class="heading"><?= __('Job Site Management') ?></li>
				
				<li><?= $this->Html->link(__('Jobs with Todos'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
				<li><?= $this->Html->link(__('Master Site List'), ['controller' => 'jobs', 'action' => 'report']) ?></li>
				<li><?= $this->Html->link(__('Claim Sites'), ['controller' => 'Jobs', 'action' => 'claim']) ?></li>

			<?php endif; ?>

			<?php if( 'admin' ==  $user_role) :?>

			<li class="heading"><?= __('Job Assignment') ?></li>
			
				<li><?= $this->Html->link(__('Manage Groups'), ['controller' => 'groups', 'action' => 'index']) ?></li>
				<li><?= $this->Html->link(__('Merge Groups'), ['controller' => 'groups', 'action' => 'merge']) ?></li>
				<li><?= $this->Html->link(__('Split Groups'), ['controller' => 'groups', 'action' => 'split']) ?></li>
				<li><?= $this->Html->link(__('Assign Groups to Sites'), ['controller' => 'jobs', 'action' => 'assign']) ?></li>
			
			<li class="heading"><?= __('Admin') ?></li>
			
				<li><?= $this->Html->link(_('Manage Users'), ['controller' => 'users', 'action' => 'index']) ?></li>
				<li><?= $this->Html->link(__('Manage Documents'), ['controller' => 'documents', 'action' => 'index']) ?></li>
				<li><?= $this->Html->link(__('Manage Todo Templates'), ['controller' => 'todo-templates', 'action' => 'index']) ?></li>
				<li><?= $this->Html->link(__('Promote A User'), ['controller' => 'users', 'action' => 'promote'] ); ?></li>
				<li><?= $this->Html->link(__('Job Report'), ['controller' => 'Jobs', 'action' => 'report']) ?></li>
				<li><?= $this->Html->link(__('Job Tool Report'), ['controller' => 'Tools', 'action' => 'report']) ?></li>

			<?php endif; ?>

			<li class="heading"><?= __('Volunteer') ?></li>
			
				<li><?= $this->Html->link(__('Edit Profile'), ['controller' => 'users', 'action' => 'me']) ?></li>
				<li><?= $this->Html->link(__('Sign Documents'), ['controller' => 'signatures', 'action' => 'index']) ?></li>

			<li class="heading"><?= __('Groups') ?></li>

				<li><?= $this->Html->link(__('My Group'), ['controller' => 'groups', 'action' => 'me']) ?></li>
				<li><?= $this->Html->link(__('Join a Group'), ['controller' => 'groups', 'action' => 'join']) ?></li>
				<li><?= $this->Html->link(__('Create a Group'), ['controller' => 'groups', 'action' => 'create']) ?></li>

		<?php endif; ?>


	</ul>
