<div class="column large-3"></div>
<div class="column large-9">
	<h2><?= h( __("Conditions") ); ?></h2>


	<?php if( !empty($conditions) ) : ?>
		<table>
			<thead>
				<tr>
					<th><?= h(__("Condition")) ?></th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($conditions as $condition) : ?>
				<tr>
					<td><?= h($condition->title) ?></td>
					<td><?= $this->Html->link(__('Edit'), ['action' => 'edit', $condition->condition_id]) ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>

	<?php endif; ?>
</div>