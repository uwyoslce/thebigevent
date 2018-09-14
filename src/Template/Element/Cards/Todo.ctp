<?php
	if( !isset($show) || !is_array($show) )
		$show = [];

	$showDefault = [
		'job' => true
	];

	$show = array_merge($showDefault, $show);

	$classes = [];
	if( $todo->due->isToday() )
		$classes[] = "card--warning";
	if( $todo->due->isPast() )
		$classes[] = "card--danger";
	if( $todo->created->isToday() )
		$classes[] = "card--primary";			
	if( $todo->completed )
		$classes[] = "card--complete";
	else
		$classes[] = "card--incomplete"
?>
<div class="card card--todo <?= implode($classes, ' ') ?>" data-todo-id="<?= $todo->todo_id ?>">
	<div class="card__header">
		<h4>
			<?php if( $todo->user_id == $AuthUser['user_id'] ): ?>
				<label><?php echo $this->Form->checkbox('card__status-toggle', [
				'class' => [
					'card__status-toggle'
				],
				'checked' => $todo->completed
			]) ?><?= h($todo->description) ?></label>
			<?php else: ?>
<?= h($todo->description) ?>
			<?php endif; ?>
		</h4>
		<p></p>
		<?= $this->Text->autoParagraph( h($todo->long_description) ) ?>
	</div>

	<div class="card__footer">
		<?php echo $this->element('KeyValuePairs', ['pairs' => [
			'Assigned To' => $todo->user->full_name,
			'Due' => $todo->due->timeAgoInWords(),
			'Actions' => [
				$this->Html->link(__('View'), ['controller' => 'todos', 'action' => 'view', $todo->todo_id], ['class' => '']),
				$this->Html->link(__('Edit'), ['controller' => 'todos', 'action' => 'edit', $todo->todo_id], ['class' => '']),
				$this->Form->postLink(
					__('Delete'), 
					['controller' => 'todos', 'action' => 'delete', $todo->todo_id],
					[
						'confirm' => __('Are you sure you want to delete # {0}?', $todo->todo_id),
						'class' => ''
					]
				)
			]
		]]); ?>
	</div><!-- // .card__footer -->

	<?php if( $todo->has('job')  && $show['job'] ): ?>
		<?php echo $this->element('Cards/Job', ['job' => $todo->job]); ?>
	<?php endif; ?>
	

</div>