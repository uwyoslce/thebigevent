<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('My Todo List'), ['controller' => 'Todos', 'action' => 'me']) ?></li>
    </ul>
</nav>
<div class="jobs view large-9 medium-8 columns content">
	<h1>My Big Event</h1>
	<p>We have built this space to help you connect with The Big Event.</p>

	<dl>
		<dt>Your Username</dt>
		<dd><?= h($user->username) ?></dd>
		<dt>Your Timezone</dt>
		<dd><?= h($user->time_zone) ?></dd>
	</dl>

	<h2>My Identities</h2>
	<p>You can connect your account to other online identities.</p>

	<?php if( !empty($user->user_identities) ) : ?>
		<ul>
		<?php foreach($user->user_identities as $identity): ?>
			<li>
				<?= $identity->identifier ?> via <?= h($identity->realm) ?>
				(<?= $this->Form->postLink(
					__('disconnect'), [
						'action'=> 'cas',
						'disconnect',
						$identity->user_identity_id
					]) ?>)
			</li>
		<?php endforeach; ?>
		</ul>
	<?php else: ?>

	<?php endif; ?>
</div>