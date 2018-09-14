<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<?= $this->element('sidebar', ['user_role' => $AuthUser['role']]) ?>
</nav>
<div class="todos index large-9 medium-8 columns content">
	<h3><?= __('Todos') ?></h3>
	<dl class="sub-nav refiner">
	<?php 
		$refinerGroups = [
			'Assigned To' => [
				'Just Me' => [
					'active' => ($who == 'me'),
					'url' => [
						'me',
						$status
					]
				],
				'Everyone' => [
					'active' => ($who != 'me'),
					'url' => [
						'all',
						$status
					]
				]
			],
			'Status' => [
				'All' => [
					'active' => ($status == 'all'),
					'url' => [
						$who,
						'all'
					]
				],
				'Complete' => [
					'active' => ($status == 'complete'),
					'url' => [
						$who,
						'complete'
					]
				],
				'Incomplete' => [
					'active' => ($status == 'incomplete'),
					'url' => [
						$who,
						'incomplete'
					]
				],
				'Overdue' => [
					'active' => ($status == 'overdue'),
					'url' => [
						$who,
						'overdue'
					]
				]
			]
		];
		echo $this->element('Refiner', ['refinerGroups' => $refinerGroups]);
	?>
	</dl>

	<div class="cards">
		<?php foreach($todos as $todo): ?>
		<?php echo $this->element('Cards/Todo', ['todo' => $todo]); ?>
		<?php endforeach; ?>
	</div>

	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
		</ul>
		<p><?= $this->Paginator->counter() ?></p>
	</div>
</div>
