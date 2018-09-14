<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __('Actions') ?></li>

		<li><?= $this->Html->link(
				__('My Profile'),
				['action' => 'me']
			)
			?></li>

	</ul>
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</nav>
<section class="large-9 medium-8 columns content">

	<dl class="sub-nav refiner">
	<?php 
		$refinerGroups = [
			'Role' => [
				'All' => [
					'active' => ('all' == $role),
					'url' => [
						'action' => 'index',
						'all'
					]
				],
				'Administrators' => [
					'active' => ('admin' == $role),
					'url' => [
						'action' => 'index',
						'admin'
					]
				],
				'Committee Members' => [
					'active' => ('committee' == $role),
					'url' => [
						'action' => 'index',
						'committee'
					]
				],
				'Volunteers' => [
					'active' => ('volunteer' == $role),
					'url' => [
						'action' => 'index',
						'volunteer'
					]
				]
			]
		];
		echo $this->element('Refiner', ['refinerGroups' => $refinerGroups]);
	?>
	</dl>

	<?php if( empty($users) ): ?>
		<p>There are no users.</p>
	<?php else: ?>
		<table>
			<thead>
				<tr>
					<th><?= h( __('Full Name & Username') ) ?></th>
					<th><?= h( __('Email') ) ?></th>
					<th><?= h( __('Phone Number') ) ?></th>
					<th><?= h( __('Participating') ) ?></th>
					<th><?= h( __('Unsigned Signatures') ) ?></th>
					<th><?= h( __('Role') ) ?></th>

				</tr>
			</thead>
			<?php
$emails = [];
			foreach($users as $user): ?>
				<tr class="user user--<?=$user->role?>">
					<td>
						<strong><?= h($user->full_name) ?></strong><br>
						@<?= h($user->username) ?>
					</td>
					<td>
						<?php
							$emails[] = $user->email;
							echo $this->Html->link(
								__('Email {0}', [$user->first_name]),
								sprintf('mailto:%s', $user->email)
							)
						?>
					</td>
					<td>
						<?php if( !empty($user->phone) ): ?>
							<?= h($user->phone) ?>
						<?php else: ?>
							&mdash;
						<?php endif; ?>
					</td>
					<td><?= ( $user->participating ) ? __("Yes") : __("No") ?></td>
					<td><?= number_format($user->signatures_unsigned) ?></td>
					<td>
						<?php if('admin' == $user->role) echo  __('Administrator'); ?>
						<?php if('committee' == $user->role) echo __('Committee Member'); ?>
						<?php if('volunteer' == $user->role) echo __('Volunteer'); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			<tfoot>
			<tr>
				<td>&nbsp;</td>
				<td><?= $this->Html->link( __('Email All'),
					sprintf('mailto:%s', implode(';', $emails))
				) ?>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			</tfoot>
		</table>
	<?php endif; ?>
</section>