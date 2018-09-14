<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Todo Template'), ['action' => 'add']) ?></li>
    </ul>
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</nav>
<div class="todosTemplates index large-9 medium-8 columns content">
    <h3><?= __('Todo Templates') ?></h3>
    <p><?= __("Todo templates are automatically applied to all new jobs and assigned a custom due date.") ?></p>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('todo_template_id') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('due_description') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todosTemplates as $todosTemplate): ?>
            <tr>
                <td><?= $this->Number->format($todosTemplate->todo_template_id) ?></td>
                <td><?= h($todosTemplate->description) ?></td>
                <td><?= h($todosTemplate->due_description) ?></td>
                <td><?= h($todosTemplate->created) ?></td>
                <td><?= h($todosTemplate->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $todosTemplate->todo_template_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $todosTemplate->todo_template_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $todosTemplate->todo_template_id], ['confirm' => __('Are you sure you want to delete # {0}?', $todosTemplate->todo_template_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
