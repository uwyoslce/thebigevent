<div class="column large-3">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</div>
<div class="column large-9 content">
	<h1>Groups</h1>

	<?php if( empty($groups) ): ?>
		<?= __("There are currently no groups"); ?>
	<?php else: ?>
		<table class="table-auto">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>Title</th>
					<th>Join&nbsp;Token</th>
					<th>Members</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($groups as $group): ?>
				<tr>
					<td class="cell-shrink"><?= $this->Html->link(__('Manage'), [
							'action' => 'manage',
							$group->group_id
						], [
							'class' => 'button button-uwyo-gold tiny'
						]) ?></td>
					<td><?= h($group->title) ?></td>
					<td class="cell-shrink"><?= h($group->join_token) ?></td>
					<td class="cell-shrink"><?= number_format($group->member_count) ?></td>
					<td class="cell-shrink"><?= $this->Form->postLink(__('Delete'), [
						'action' => 'delete',
						$group->group_id
					], [
							'class' => 'button alert tiny'
						]); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>