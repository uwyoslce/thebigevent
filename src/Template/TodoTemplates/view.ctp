<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Todos Template'), ['action' => 'edit', $todosTemplate->todo_template_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Todos Template'), ['action' => 'delete', $todosTemplate->todo_template_id], ['confirm' => __('Are you sure you want to delete # {0}?', $todosTemplate->todo_template_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Todos Templates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Todos Template'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="todosTemplates view large-9 medium-8 columns content">
    <h3><?= h($todosTemplate->todo_template_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Description') ?></th>
            <td><?= h($todosTemplate->description) ?></td>
        </tr>
        <tr>
            <th><?= __('Due Description') ?></th>
            <td><?= h($todosTemplate->due_description) ?></td>
        </tr>
        <tr>
            <th><?= __('Todo Template Id') ?></th>
            <td><?= $this->Number->format($todosTemplate->todo_template_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($todosTemplate->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($todosTemplate->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Long Description') ?></h4>
        <?= $this->Text->autoParagraph(h($todosTemplate->long_description)); ?>
    </div>
</div>
