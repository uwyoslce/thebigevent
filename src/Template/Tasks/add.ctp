<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tasks form large-9 medium-8 columns content">
    <?= $this->Form->create($task) ?>
    <fieldset>
        <legend><?= __('Add Task') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('indoor');
            echo $this->Form->control('outdoor');
            echo $this->Form->control('jobs._ids', ['options' => $jobs]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
