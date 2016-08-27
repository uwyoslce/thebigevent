
<div class="card card--job" data-job-id="<?= $job->job_id ?>">
	<div class="card__header">
		<p><strong>Job:</strong> <?= $this->Html->link($job->display_field, [
			'controller' => 'Jobs',
			'action' => 'view',
			$job->job_id
		]); ?></p>
		<?php echo $this->Text->autoParagraph($job->job_description); ?>
	</div>

	<section class="card--job__notes">
		<h4>Notes</h4>
		<div class="card--job__notes__notes">
			<?php echo $this->Text->autoParagraph($job->notes); ?>
		</div>
		<input type="text" class="card--job__notes__note" placeholder="add a quick note: type and press enter to save">
	</section>

	<div class="card__footer">
		<?php echo $this->element('KeyValuePairs', [
			'pairs' => [
				'Volunteers Needed' => $job->volunteer_count,
				'Todos' => [
					$job->todos_incomplete,
					" incomplete +",
					$job->todos_complete,
					" complete =",
					$job->todos_complete + $job->todos_incomplete,
					"total"],
				'Email' => $job->contact_email,
				'Phone' => $job->contact_phone,
				'Best Time To Contact' => $job->contact_best_time_to_call,
				'Job Actions' => [
					$this->Html->link(__('View'), [
						'controller' => 'Jobs',
						'action' => 'view',
						$job->job_id
					]),
					$this->Html->link(__('Edit'), [
						'controller' => 'Jobs',
						'action' => 'edit',
						$job->job_id
					]),
					$this->Form->postLink(__('Delete'), [
						'controller' => 'Jobs',
						'action' => 'delete',
						$job->job_id
					], [
						'confirm' => __('Are you sure you want to delete this job?')
					])
				]
			]
		]); ?>
	</div>
	<?php if( $job->has('todos') ): ?>
	<section class="cards__todos">
		<?php foreach($job->todos as $todo)
			echo $this->element('Cards/Todo', ['todo' => $todo, 'show' => ['job' => false]]); ?>
	</section>
	<?php endif; ?>
</div>
				