<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Organization'), ['action' => 'edit', $organization->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Organization'), ['action' => 'delete', $organization->id], ['confirm' => __('Are you sure you want to delete # {0}?', $organization->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Organization'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Organization'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Job'), ['controller' => 'Job', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Job', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Organization Has Job'), ['controller' => 'OrganizationHasJob', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Organization Has Job'), ['controller' => 'OrganizationHasJob', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Has Organization'), ['controller' => 'UserHasOrganization', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Has Organization'), ['controller' => 'UserHasOrganization', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Has Participation Request'), ['controller' => 'UserHasParticipationRequest', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Has Participation Request'), ['controller' => 'UserHasParticipationRequest', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="organization view large-9 medium-8 columns content">
    <h3><?= h($organization->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Org Name') ?></th>
            <td><?= h($organization->org_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Access Code') ?></th>
            <td><?= h($organization->access_code) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($organization->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Deleted At') ?></th>
            <td><?= h($organization->deleted_at) ?></td>
        </tr>
        <tr>
            <th><?= __('Flag Indiv') ?></th>
            <td><?= $organization->flag_indiv ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Flag Indiv Split') ?></th>
            <td><?= $organization->flag_indiv_split ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Flag Split') ?></th>
            <td><?= $organization->flag_split ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Flag Fishcamp') ?></th>
            <td><?= $organization->flag_fishcamp ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Flag Backup') ?></th>
            <td><?= $organization->flag_backup ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Flag Corps') ?></th>
            <td><?= $organization->flag_corps ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Job') ?></h4>
        <?php if (!empty($organization->job)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Job Number') ?></th>
                <th><?= __('Deleted At') ?></th>
                <th><?= __('Job Description') ?></th>
                <th><?= __('Organization Id') ?></th>
                <th><?= __('Team Id') ?></th>
                <th><?= __('Date Received') ?></th>
                <th><?= __('Date Check By') ?></th>
                <th><?= __('Contact Organization') ?></th>
                <th><?= __('Contact Firstname') ?></th>
                <th><?= __('Contact Lastname') ?></th>
                <th><?= __('Contact Address') ?></th>
                <th><?= __('Contact City') ?></th>
                <th><?= __('Contact Zip') ?></th>
                <th><?= __('Contact Home Phone') ?></th>
                <th><?= __('Contact Work Phone') ?></th>
                <th><?= __('Contact Mobile Phone') ?></th>
                <th><?= __('Contact Best Time To Call') ?></th>
                <th><?= __('Contact Email') ?></th>
                <th><?= __('Recipient Bio') ?></th>
                <th><?= __('Job Zone') ?></th>
                <th><?= __('Is Target Zone') ?></th>
                <th><?= __('Job Team Num') ?></th>
                <th><?= __('Students Needed') ?></th>
                <th><?= __('Students Assigned') ?></th>
                <th><?= __('Is Job Site Check Complete') ?></th>
                <th><?= __('Is Risk Eval Complete') ?></th>
                <th><?= __('Is Risk Flagged') ?></th>
                <th><?= __('Risk Reason') ?></th>
                <th><?= __('Is Indem Complete') ?></th>
                <th><?= __('Is Map Complete') ?></th>
                <th><?= __('Special Needs') ?></th>
                <th><?= __('Special Needs Other') ?></th>
                <th><?= __('Gender Pref') ?></th>
                <th><?= __('All Tools Provided') ?></th>
                <th><?= __('Has Other Tools') ?></th>
                <th><?= __('Other Tools') ?></th>
                <th><?= __('Tool Distribution Line') ?></th>
                <th><?= __('Parking Pass') ?></th>
                <th><?= __('Is Cancelled') ?></th>
                <th><?= __('Cancel Reason') ?></th>
                <th><?= __('Cancel Date') ?></th>
                <th><?= __('Is Completable In Rain') ?></th>
                <th><?= __('Is Completable Indoors') ?></th>
                <th><?= __('Is Completable Outdoors') ?></th>
                <th><?= __('Is Completable Both') ?></th>
                <th><?= __('Is Checked In') ?></th>
                <th><?= __('Date Checked In') ?></th>
                <th><?= __('Is Media Job') ?></th>
                <th><?= __('Is Backup Job') ?></th>
                <th><?= __('See Solutions') ?></th>
                <th><?= __('Referral') ?></th>
                <th><?= __('Comments') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($organization->job as $job): ?>
            <tr>
                <td><?= h($job->id) ?></td>
                <td><?= h($job->job_number) ?></td>
                <td><?= h($job->deleted_at) ?></td>
                <td><?= h($job->job_description) ?></td>
                <td><?= h($job->organization_id) ?></td>
                <td><?= h($job->team_id) ?></td>
                <td><?= h($job->date_received) ?></td>
                <td><?= h($job->date_check_by) ?></td>
                <td><?= h($job->contact_organization) ?></td>
                <td><?= h($job->contact_firstname) ?></td>
                <td><?= h($job->contact_lastname) ?></td>
                <td><?= h($job->contact_address) ?></td>
                <td><?= h($job->contact_city) ?></td>
                <td><?= h($job->contact_zip) ?></td>
                <td><?= h($job->contact_home_phone) ?></td>
                <td><?= h($job->contact_work_phone) ?></td>
                <td><?= h($job->contact_mobile_phone) ?></td>
                <td><?= h($job->contact_best_time_to_call) ?></td>
                <td><?= h($job->contact_email) ?></td>
                <td><?= h($job->recipient_bio) ?></td>
                <td><?= h($job->job_zone) ?></td>
                <td><?= h($job->is_target_zone) ?></td>
                <td><?= h($job->job_team_num) ?></td>
                <td><?= h($job->students_needed) ?></td>
                <td><?= h($job->students_assigned) ?></td>
                <td><?= h($job->is_job_site_check_complete) ?></td>
                <td><?= h($job->is_risk_eval_complete) ?></td>
                <td><?= h($job->is_risk_flagged) ?></td>
                <td><?= h($job->risk_reason) ?></td>
                <td><?= h($job->is_indem_complete) ?></td>
                <td><?= h($job->is_map_complete) ?></td>
                <td><?= h($job->special_needs) ?></td>
                <td><?= h($job->special_needs_other) ?></td>
                <td><?= h($job->gender_pref) ?></td>
                <td><?= h($job->all_tools_provided) ?></td>
                <td><?= h($job->has_other_tools) ?></td>
                <td><?= h($job->other_tools) ?></td>
                <td><?= h($job->tool_distribution_line) ?></td>
                <td><?= h($job->parking_pass) ?></td>
                <td><?= h($job->is_cancelled) ?></td>
                <td><?= h($job->cancel_reason) ?></td>
                <td><?= h($job->cancel_date) ?></td>
                <td><?= h($job->is_completable_in_rain) ?></td>
                <td><?= h($job->is_completable_indoors) ?></td>
                <td><?= h($job->is_completable_outdoors) ?></td>
                <td><?= h($job->is_completable_both) ?></td>
                <td><?= h($job->is_checked_in) ?></td>
                <td><?= h($job->date_checked_in) ?></td>
                <td><?= h($job->is_media_job) ?></td>
                <td><?= h($job->is_backup_job) ?></td>
                <td><?= h($job->see_solutions) ?></td>
                <td><?= h($job->referral) ?></td>
                <td><?= h($job->comments) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Job', 'action' => 'view', $job->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Job', 'action' => 'edit', $job->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Job', 'action' => 'delete', $job->id], ['confirm' => __('Are you sure you want to delete # {0}?', $job->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Organization Has Job') ?></h4>
        <?php if (!empty($organization->organization_has_job)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Organization Id') ?></th>
                <th><?= __('Job Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($organization->organization_has_job as $organizationHasJob): ?>
            <tr>
                <td><?= h($organizationHasJob->organization_id) ?></td>
                <td><?= h($organizationHasJob->job_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'OrganizationHasJob', 'action' => 'view', $organizationHasJob->organization_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'OrganizationHasJob', 'action' => 'edit', $organizationHasJob->organization_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrganizationHasJob', 'action' => 'delete', $organizationHasJob->organization_id], ['confirm' => __('Are you sure you want to delete # {0}?', $organizationHasJob->organization_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related User Has Organization') ?></h4>
        <?php if (!empty($organization->user_has_organization)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('User Id') ?></th>
                <th><?= __('Organization Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($organization->user_has_organization as $userHasOrganization): ?>
            <tr>
                <td><?= h($userHasOrganization->user_id) ?></td>
                <td><?= h($userHasOrganization->organization_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UserHasOrganization', 'action' => 'view', $userHasOrganization->user_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserHasOrganization', 'action' => 'edit', $userHasOrganization->user_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserHasOrganization', 'action' => 'delete', $userHasOrganization->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $userHasOrganization->user_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related User Has Participation Request') ?></h4>
        <?php if (!empty($organization->user_has_participation_request)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('User Id') ?></th>
                <th><?= __('Organization Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($organization->user_has_participation_request as $userHasParticipationRequest): ?>
            <tr>
                <td><?= h($userHasParticipationRequest->user_id) ?></td>
                <td><?= h($userHasParticipationRequest->organization_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UserHasParticipationRequest', 'action' => 'view', $userHasParticipationRequest->user_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserHasParticipationRequest', 'action' => 'edit', $userHasParticipationRequest->user_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserHasParticipationRequest', 'action' => 'delete', $userHasParticipationRequest->user_id], ['confirm' => __('Are you sure you want to delete # {0}?', $userHasParticipationRequest->user_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
