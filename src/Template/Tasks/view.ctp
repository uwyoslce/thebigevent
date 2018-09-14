<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Task'), ['action' => 'edit', $task->task_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Task'), ['action' => 'delete', $task->task_id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->task_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tasks view large-9 medium-8 columns content">
    <h3><?= h($task->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Task') ?></th>
            <td><?= $task->has('task') ? $this->Html->link($task->task->title, ['controller' => 'Tasks', 'action' => 'view', $task->task->task_id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($task->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($task->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($task->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Indoor') ?></th>
            <td><?= $task->indoor ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Outdoor') ?></th>
            <td><?= $task->outdoor ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Jobs') ?></h4>
        <?php if (!empty($task->jobs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Job Id') ?></th>
                <th><?= __('Contact First Name') ?></th>
                <th><?= __('Contact Last Name') ?></th>
                <th><?= __('Contact Phone') ?></th>
                <th><?= __('Contact Email') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->jobs as $jobs): ?>
            <tr>
                <td><?= h($jobs->job_id) ?></td>
                <td><?= h($jobs->contact_first_name) ?></td>
                <td><?= h($jobs->contact_last_name) ?></td>
                <td><?= h($jobs->contact_phone) ?></td>
                <td><?= h($jobs->contact_email) ?></td>
                <td><?= h($jobs->created) ?></td>
                <td><?= h($jobs->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Jobs', 'action' => 'view', $jobs->job_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Jobs', 'action' => 'edit', $jobs->job_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Jobs', 'action' => 'delete', $jobs->job_id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobs->job_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
