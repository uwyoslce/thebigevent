<aside class="columns large-3">
	<?= $this->Element('sidebar', ['user_role' => $AuthUser['role']]) ?>
</aside>
<main class="columns large-9 content">
	<?= $this->Form->create(null) ?>
		<div class="row">
			<div class="columns large-12">

			<h2><?= __('Assign Groups') ?></h2>
			<p><?= __('Assign any group to any job') ?></p>
			<?php
				// jobs then filters
			$refinerGroups = [
				
				'Jobs' => [
					
					'Unassigned' => [
						'active' => ( 'unassigned' == $job_filter),
						'url' => [
							'action' => 'assign',
							'unassigned',
							$group_filter,
						]
					],
					'All' => [
						'active' => ( 'all' == $job_filter ),
						'url' => [
							'action' => 'assign',
							'all',
							$group_filter,
						]
					],
				],

				'Groups' => [
					
					'Unassigned' => [
						'active' => ('unassigned' == $group_filter),
						'url' => [
							'action' => 'assign',
							$job_filter,
							'unassigned'
						]
					],
					'All' => [
						'active' => ( 'all' == $group_filter),
						'url' => [
							'action' => 'assign',
							$job_filter,
							'all'
						]
					],
				],
			];
?>	
	<dl class="sub-nav refiner">
		<?= $this->Element('Refiner', ['refinerGroups' => $refinerGroups ]) ?>
	</dl>
			</div>

			<div class="columns large-5"><?= $this->Form->control('job_id'); ?></div>
			<div class="columns large-5"><?= $this->Form->control('group_id'); ?></div>
			<div class="columns large-12">
				<?= $this->Form->control('take', [
					'type' => 'checkbox',
					'value' => true,
					'label' => __("Take job volunteer requirement from Group if Group has more than Job needs."),
					'checked' => true
				]); ?>
			</div>
			<div class="columns large-12">
				<?= $this->Form->button('Assign') ?>
			</div>
		</div>	
	<?= $this->Form->end(); ?>
</main>