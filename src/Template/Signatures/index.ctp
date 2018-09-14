<aside class="column large-3">
	<?php echo $this->Element( 'sidebar', [ 'user_role' => $AuthUser['role'] ] ); ?>
</aside>
<article class="column large-9 content">
	<h1><?= __('My Signatures') ?></h1>
	<p><?= __('These are digital documents you need to sign before you can participate in The Big Event.') ?></p>

	<?php if( $user_signatures->count() > 0 ): ?>
		<table>
			<thead>
			<tr>
				<th><?= __('Document Title'); ?></th>
				<th><?= __('Signature'); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($user_signatures as $signature): ?>
				<tr>
					<td><?= h($signature->document->title) ?> (<?= $this->Html->link( __('View Document'), $signature->document->path ); ?>)</td>
					<td><?php
						if( $signature->signed ) {
							echo __('Signed {0}: <code>{1}</code>', [
								$signature->modified->i18nFormat(\IntlDateFormatter::FULL, $AuthUser['time_zone']),
								$signature->signature_text
							]);
						} else {
							echo $this->Html->link(__("Sign Now"), [
								'action' => 'sign',
								$signature->signature_id
							]);
						}
					?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

	<?php else: ?>
		<p><?= __('There are no documents for you to sign at this time.'); ?></p>
			<p><?= __('If you haven\'t clicked the "I am participating in The Big Event" button on your profile, you need to do that before you can sign documents.'); ?></p>
		<p><?= $this->Html->link(__('Go To Profile'), ['controller' => 'users', 'action' => 'me']) ?></p>
	<?php endif; ?>
</article>