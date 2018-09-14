<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Todo'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="todos index large-9 medium-8 columns content">
    <h3><?= __('My Todos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('job_id') ?></th>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('due') ?></th>
                <th><?= $this->Paginator->sort('completed') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todos as $todo): ?>
            <tr>
                <td><?= $todo->has('job') ? $this->Html->link($todo->job->display_field, ['controller' => 'Jobs', 'action' => 'view', $todo->job->job_id]) : '' ?></td>
                <td><?= $todo->has('user') ? $this->Html->link($todo->user->username, ['controller' => 'Users', 'action' => 'view', $todo->user->user_id]) : '' ?></td>
                <td><?= h($todo->description) ?></td>
                <td><?= h( $this->Time->timeAgoInWords($todo->due) ) ?></td>
                <td><?= h($todo->completed) ?></td>
                <td><?= h($todo->created) ?></td>
                <td><?= h($todo->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__("Complete"), [
                        'action' => 'complete',
                        $todo->todo_id
                    ]) ?>
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
