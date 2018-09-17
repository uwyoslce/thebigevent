<div class="column large-3">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</div>
<div class="column large-9 content">

    <div class="row">
        <section class="column large-11">
            <h2><?php echo $group->title ?></h2>

            <h3>Your group's token is
                <code><?= $group->join_token ?></code></h3>
            <p>Share this token with anyone who would like to become a member of your group.</p>
        </section>
    </div>
	
	<?php if ($group->has('jobs')): ?>
		<?php if (empty($group->jobs)): ?>
            <p><em><?= __("Your group hasn't been assigned a job site yet.") ?></em></p>
		<?php else: ?>
			<?php foreach ($group->jobs as $job): ?>
                <div class="row">
                    <div class="column large-8">
                        <h4><?= __('Job Assignment'); ?></h4>
                        <p>
                            <strong><?= $job->contact_first_name ?> <?= $job->contact_last_name ?></strong><br>
                        </p>
						<?= $this->Text->autoParagraph($job->job_description) ?>
                    </div>
                    <div class="column large-4">
                        <h4><?= __('Your Site Leader'); ?></h4>
						<?php if ($job->site_leader): ?>
                            <p><strong><?= h($job->site_leader->full_name) ?></strong><br>
								<?= h($job->site_leader->email) ?>
                            </p>
                            <p><?= $this->Html->link(__('Email {0}', [$job->site_leader->first_name]), 'mailto:' . $job->site_leader->email, ['class' => 'button tiny']); ?></p>

                            <p><?= __('Contact your site leader if you have any questions or concerns before or during {0}.', [
								\Cake\Core\Configure::read('TheBigEvent.name')
							]); ?>
						
						<?php else: ?>
                            <p><?= __('This job does not yet have a site leader'); ?></p>
						<?php endif; ?>
                    </div>
                </div>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endif; ?>
    <div class="row">
        <div class="large-12 columns">
			<?php if (empty($group->users)) : ?>
                <p>There are no members in this group!</p>
			<?php else: ?>
                <table>
                    <thead>
                    <tr>
                        <th>Group Role</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					$emails = [];
					foreach ($group->users as $member):
						$emails[] = $member->email;
						?>
                        <tr>
                            <td><?= $member->_joinData->role ?></td>
                            <td><?= $member->username ?></td>
                            <td><?= $member->first_name ?></td>
                            <td><?= $member->last_name ?></td>
                            <td><?= $member->email ?></td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
				<?php
				$link = sprintf('mailto:%s?Subject=%s',
					implode(',', $emails),
					rawurlencode(
                        __( "[{1}] {0} - Group", [
                            $group->title,
                            \Cake\Core\Configure::read('TheBigEvent.name')
                        ])
					
					)
				);
				// mailto:person1@uwyo.edu,person2@uwyo.edu?Subject=%5BThe%20Big%20Event%5D%20Group%3A%20name
				echo $this->Html->link(__('Create Group Email'), $link, ['class' => 'button']);
				?>
			<?php endif; ?>
        </div>
    </div>
</div>
