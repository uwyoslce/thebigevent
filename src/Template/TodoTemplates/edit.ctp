<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $todosTemplate->todo_template_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $todosTemplate->todo_template_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Todos Templates'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="todosTemplates form large-9 medium-8 columns content">
    <?= $this->Form->create($todosTemplate) ?>
    <fieldset>
        <legend><?= __('Edit Todos Template') ?></legend>
        <?php
            echo $this->Form->control('description');
            echo $this->Form->control('long_description');
            echo $this->Form->control('due_description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
