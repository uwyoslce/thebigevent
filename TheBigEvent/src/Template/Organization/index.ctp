<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Organization'), ['action' => 'add']) ?></li>
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
<div class="organization index large-9 medium-8 columns content">
    <h3><?= __('Organization') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('deleted_at') ?></th>
                <th><?= $this->Paginator->sort('org_name') ?></th>
                <th><?= $this->Paginator->sort('access_code') ?></th>
                <th><?= $this->Paginator->sort('flag_indiv') ?></th>
                <th><?= $this->Paginator->sort('flag_indiv_split') ?></th>
                <th><?= $this->Paginator->sort('flag_split') ?></th>
                <th><?= $this->Paginator->sort('flag_fishcamp') ?></th>
                <th><?= $this->Paginator->sort('flag_backup') ?></th>
                <th><?= $this->Paginator->sort('flag_corps') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($organization as $organization): ?>
            <tr>
                <td><?= $this->Number->format($organization->id) ?></td>
                <td><?= h($organization->deleted_at) ?></td>
                <td><?= h($organization->org_name) ?></td>
                <td><?= h($organization->access_code) ?></td>
                <td><?= h($organization->flag_indiv) ?></td>
                <td><?= h($organization->flag_indiv_split) ?></td>
                <td><?= h($organization->flag_split) ?></td>
                <td><?= h($organization->flag_fishcamp) ?></td>
                <td><?= h($organization->flag_backup) ?></td>
                <td><?= h($organization->flag_corps) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $organization->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $organization->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $organization->id], ['confirm' => __('Are you sure you want to delete # {0}?', $organization->id)]) ?>
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
