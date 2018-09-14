<div class="column large-3">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</div>
<div class="jobs index large-9 medium-8 columns content">
	<h3><?= __('Jobs') ?></h3>
	<p><?= $this->Html->link( __('View Job Master List'), ['action' => 'report'], ['class' => 'button']) ?>
<div class="append-bottom">
	<?php foreach($jobs as $job) : ?>
		<?php echo $this->element('Cards/Job', ['job'=> $job]); ?>
	<?php endforeach; ?>
</div>
	<div class="paginator">
		<ul class="pagination">
			<?= $this->Paginator->prev('< ' . __('previous')) ?>
			<?= $this->Paginator->numbers() ?>
			<?= $this->Paginator->next(__('next') . ' >') ?>
		</ul>
		<p><?= $this->Paginator->counter([
    'format' => 'Page {{page}} of {{pages}}, showing {{current}} records out of
             {{count}} total, starting on record {{start}}, ending on {{end}}'
]) ?></p>
	</div>
</div>
