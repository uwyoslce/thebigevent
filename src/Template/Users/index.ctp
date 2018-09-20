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
						'all',
					],
				],
				'Administrators' => [
					'active' => ('admin' == $role),
					'url' => [
						'action' => 'index',
						'admin',
					],
				],
				'Committee Members' => [
					'active' => ('committee' == $role),
					'url' => [
						'action' => 'index',
						'committee',
					],
				],
				'Volunteers' => [
					'active' => ('volunteer' == $role),
					'url' => [
						'action' => 'index',
						'volunteer',
					],
				],
			],
		];
		echo $this->element('Refiner', ['refinerGroups' => $refinerGroups]);
		?>
    </dl>
	
	<?php if (empty($users)): ?>
        <p>There are no users.</p>
	<?php else: ?>
        <table class="table-auto">
            <thead>
            <tr>
				<?php if (\Cake\Core\Configure::read('debug')): ?>
                    <th>user_id</th>
				<?php endif; ?>
                <th>&nbsp;</th>
                <th class="u-nowrap"><?= h(__('Full Name & Username')) ?></th>
                <th class="u-nowrap"><?= h(__('Phone Number')) ?></th>
                <th class="u-nowrap"><?= h(__('Participating')) ?></th>
                <th class="u-nowrap"><?= h(__('Unsigned Signatures')) ?></th>
                <th class="u-nowrap"><?= h(__('Role')) ?></th>
                <th class="u-nowrap"><?= h(__('Email')) ?></th>

            </tr>
            </thead>
			<?php
			$emails = [];
			foreach ($users as $user): ?>
                <tr class="user user--<?= $user->role ?>">
					<?php if (\Cake\Core\Configure::read('debug')): ?>
                        <td class="cell-shrink"><?= $user->user_id ?></td>
					<?php endif; ?>
                    <td class="cell-shrink">
						<?= $this->Html->link(__('Manage Conditions'), [
							'action' => 'conditions',
							$user->user_id,
						],
							[
								'class' => 'button button-uwyo-gold tiny u-nowrap',
							]); ?>
                    </td>
                    <td>
                        <strong><?= h($user->full_name) ?></strong><br>
                        @<?= h($user->username) ?>
                    </td>

                    <td class="cell-shrink">
						<?php if (!empty($user->phone)): ?>
							<?= h($user->phone) ?>
						<?php else: ?>
                            &mdash;
						<?php endif; ?>
                    </td>
                    <td class="cell-shrink"><?= ($user->participating) ? __("Yes") : __("No") ?></td>
                    <td class="cell-shrink"><?= number_format($user->signatures_unsigned) ?></td>
                    <td class="cell-shrink u-nowrap">
						<?php if ('admin' == $user->role) {
							echo __('Administrator');
						}
						?>
						<?php if ('committee' == $user->role) {
							echo __('Committee Member');
						}
						?>
						<?php if ('volunteer' == $user->role) {
							echo __('Volunteer');
						}
						?>
                    </td>
                    <td class="cell-shrink">
						<?php
						$emails[] = $user->email;
						echo $this->Html->link(
							__('Email {0}', [$user->first_name]),
							sprintf('mailto:%s', $user->email),
							['class' => 'button button-primary tiny button-block']
						)
						?>
                    </td>
                </tr>
			<?php endforeach; ?>
            <tfoot>
            <tr>
				<?php if (\Cake\Core\Configure::read('debug')): ?>
                    <td>&nbsp;</td>
				<?php endif; ?>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><?= $this->Html->link(__('Email All'),
						sprintf('mailto:%s', implode(';', $emails)),
                            ['class' => 'button button-primary large u-nowrap']
					) ?>
                </td>
            </tr>
            </tfoot>
        </table>
	<?php endif; ?>
</section>