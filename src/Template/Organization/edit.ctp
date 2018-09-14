<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $organization->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $organization->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Organization'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Job'), ['controller' => 'Job', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Job', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Organization Has Job'), ['controller' => 'OrganizationHasJob', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Organization Has Job'), ['controller' => 'OrganizationHasJob', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Has Organization'), ['controller' => 'UserHasOrganization', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Has Organization'), ['controller' => 'UserHasOrganization', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Has Participation Request'), ['controller' => 'UserHasParticipationRequest', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Has Participation Request'), ['controller' => 'UserHasParticipationRequest', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="organization form large-9 medium-8 columns content">
    <?= $this->Form->create($organization) ?>
    <fieldset>
        <legend><?= __('Edit Organization') ?></legend>
        <?php
            echo $this->Form->control('deleted_at', ['empty' => true]);
            echo $this->Form->control('org_name');
            echo $this->Form->control('access_code');
            echo $this->Form->control('flag_indiv');
            echo $this->Form->control('flag_indiv_split');
            echo $this->Form->control('flag_split');
            echo $this->Form->control('flag_fishcamp');
            echo $this->Form->control('flag_backup');
            echo $this->Form->control('flag_corps');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
