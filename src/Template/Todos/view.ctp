<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Todo'), ['action' => 'edit', $todo->todo_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Todo'), ['action' => 'delete', $todo->todo_id], ['confirm' => __('Are you sure you want to delete # {0}?', $todo->todo_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Todos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Todo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Todos'), ['controller' => 'Todos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Todo'), ['controller' => 'Todos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="todos view large-9 medium-8 columns content">
    <h3><?= h($todo->todo_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $todo->has('user') ? $this->Html->link($todo->user->username, ['controller' => 'Users', 'action' => 'view', $todo->user->user_id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($todo->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Due') ?></th>
            <td><?= h($todo->due) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($todo->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($todo->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Completed') ?></th>
            <td><?= $todo->completed ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= h($todo->model) ?></h4>
        <p><?= $this->Html->link( $related_entity->display_field, ['controller' => $todo->model, 'action' => 'view', $todo->model_id ]) ?></p>
    </div>
    <div class="row">
        <h4><?= __('Long Description') ?></h4>
        <?= $this->Text->autoParagraph(h($todo->long_description)); ?>
    </div>
</div>
