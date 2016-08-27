<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Job'), ['action' => 'edit', $job->job_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Job'), ['action' => 'delete', $job->job_id], ['confirm' => __('Are you sure you want to delete # {0}?', $job->job_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Jobs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="jobs view large-9 medium-8 columns content">
    <h3><?= h($job->job_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Job') ?></th>
            <td><?= $job->has('job') ? $this->Html->link($job->job->job_id, ['controller' => 'Jobs', 'action' => 'view', $job->job->job_id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Contact First Name') ?></th>
            <td><?= h($job->contact_first_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Contact Last Name') ?></th>
            <td><?= h($job->contact_last_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Contact Phone') ?></th>
            <td><?= h($job->contact_phone) ?></td>
        </tr>
        <tr>
            <th><?= __('Contact Email') ?></th>
            <td><?= h($job->contact_email) ?></td>
        </tr>
        <tr>
            <th><?= __('Contact Address 1') ?></th>
            <td><?= h($job->contact_address_1) ?></td>
        </tr>
        <tr>
            <th><?= __('Contact Address 2') ?></th>
            <td><?= h($job->contact_address_2) ?></td>
        </tr>
        <tr>
            <th><?= __('Contact City') ?></th>
            <td><?= h($job->contact_city) ?></td>
        </tr>
        <tr>
            <th><?= __('Contact State') ?></th>
            <td><?= h($job->contact_state) ?></td>
        </tr>
        <tr>
            <th><?= __('Contact Zip') ?></th>
            <td><?= h($job->contact_zip) ?></td>
        </tr>
        <tr>
            <th><?= __('Contact Best Time To Call') ?></th>
            <td><?= h($job->contact_best_time_to_call) ?></td>
        </tr>
        <tr>
            <th><?= __('Referral') ?></th>
            <td><?= h($job->referral) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($job->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($job->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Job Description') ?></h4>
        <?= $this->Text->autoParagraph(h($job->job_description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Todos') ?></h4>
        <?php if( !empty($job->todos) ) : ?>
            <?php foreach($job->todos as $todo): ?>
                <?php echo $this->element('Cards/Todo', [
                    'todo' => $todo,
                    'show' => [
                        'job' => false
                    ]
                ]); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tasks') ?></h4>
        <?php if (!empty($job->tasks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Task Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Indoor') ?></th>
                <th><?= __('Outdoor') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($job->tasks as $tasks): ?>
            <tr>
                <td><?= h($tasks->task_id) ?></td>
                <td><?= h($tasks->title) ?></td>
                <td><?= h($tasks->indoor) ?></td>
                <td><?= h($tasks->outdoor) ?></td>
                <td><?= h($tasks->created) ?></td>
                <td><?= h($tasks->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tasks', 'action' => 'view', $tasks->task_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tasks', 'action' => 'edit', $tasks->task_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tasks', 'action' => 'delete', $tasks->task_id], ['confirm' => __('Are you sure you want to delete # {0}?', $tasks->task_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
