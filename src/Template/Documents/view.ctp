<aside class="large-3 column">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</aside>
<article class="large-9 columns content">
	<h2><?= h($document->title) ?></h2>
	<p><?= $this->Html->link( __('Download Now'), $document->path ) ?></p>

	<?= $this->Element('KeyValuePairs', ['pairs' => [
		'Distributed' => $document->distributed_count,
		'Signed' => $document->signed_count,
		'Created' => $document->created->nice($AuthUser['time_zone']),
		'Modified' => $document->modified->nice($AuthUser['time_zone'])
	]]) ?>

	<hr>

	<?php if( empty($document->signatures) ): ?>
		<p><?= __('This document currently has no signatures') ?></p>
	<?php else: ?>
		<table>
			<thead>
				<tr>
					<th><?= __('Full Name') ?></th>
					<th><?= __('Profile Complete') ?></th>
					<th><?= __('Signed') ?></th>
					<th><?= __('Received') ?></th>
					<th><?= __('Signed On') ?></th>
					<th><?= __('Signature Text') ?></th>
				</tr>
			</thead>
			<?php foreach( $document->signatures as $signature ): ?>
				<tr>
					<td><?= h($signature->user->full_name) ?></td>
					<td><?= ($signature->user->profile_complete) ? __("Yes") : __("No") ?></td>
					<td><?= ($signature->signed) ? __("Yes") : __("No") ?></td>

					<td><?= $signature->created->i18nFormat(\IntlDateFormatter::SHORT, $AuthUser['time_zone']) ?></td>
					<td><?= ($signature->signed)
						? $signature->modified->i18nFormat(\IntlDateFormatter::SHORT, $AuthUser['time_zone'])
						: '&mdash;' ?></td>
					<td><?= h($signature->signature_text ) ?></td>
				</tr>
			<?php endforeach ; ?>
		</table>
	<?php endif; ?>


	<?php debug($document); ?>
</article>