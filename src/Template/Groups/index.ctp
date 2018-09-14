<div class="column large-3">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</div>
<div class="column large-9 content">
	<h1>Groups</h1>

	<?php if( empty($groups) ): ?>
		<?= __("There are currently no groups"); ?>
	<?php else: ?>
		<table>
			<thead>
				<tr>
					<th>Title</th>
					<th>Join Token</th>
					<th>Members</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($groups as $group): ?>
				<tr>

					<td><?= h($group->title) ?></td>
					<td><?= h($group->join_token) ?></td>
					<td><?= number_format($group->member_count) ?></td>
					<td>
						<?= $this->Html->link(__('Manage'), [
							'action' => 'manage',
							$group->group_id
						]) ?>
					<?= $this->Form->postLink(__('Delete'), [
						'action' => 'delete',
						$group->group_id
					]); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>