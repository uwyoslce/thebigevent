<aside class="columns large-3">
	<?= $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</aside>
<main class="columns large-9 content">
	<div class="row"><div class="large-12 columns">
	<h2><?= __("{0}'s Sites", [$user->full_name]) ?></h2>
	<p><?= __('These sites have been assigned to {0}.', [
		$AuthUser['user_id'] == $user->user_id ? __('you') : $user->full_name
	] ); ?></p>
	<p><?= $this->Html->link( __('Print Job Slips'), ['controller' => 'jobs', 'action' => 'printing', $user->user_id], ['class' => 'button primary']) ?></p>
	
	<?php if( count($user->site_leader_jobs) > 0 ): ?>
		<?php $master_tools = []; ?>

		<?php foreach($user->site_leader_jobs as $job): ?>
		
			<div class="row">
				<div class="large-9 columns">
					<p>
						<strong><?= $job->contact_first_name ?> <?= $job->contact_last_name ?></strong><br>
						<?= $job->contact_address_1 ?><br>
						<?php if ($job->contact_address_2): ?>
								<?= h($job->contact_address_2) ?><br>
						<?php endif;?>
						<?= __("{0}, {1} {2}", [
								$job->contact_city,
								$job->contact_state,
								$job->contact_zip
						]) ?>
					</p>
					<?= $this->Text->autoParagraph($job->job_description); ?>
				</div>
				<div class="large-3 columns text-right">
					<?= $this->Html->link(__('Edit Job'), [
						'controller' => 'Jobs',
						'action' => 'edit',
						$job->job_id
					],[
						'class' => 'button primary tiny'
					]) ?>					
				</div>
			</div>

			<div class="row">
				<div class="large-12 columns append-bottom">
					<?php echo $this->Element('KeyValuePairs', ['pairs' =>[ 
						'Volunteers Needed' => number_format($job->volunteer_count),
						'Requires Vehicle' => (count($job->conditions)>0) ? __('Yes') : __('No')
					] ] ); ?>
				</div>
			</div>

		
			<div class="row">
			<div class="large-12 columns">
			<?php if( !empty($job->groups) ): ?>
				<h4><?= __('Groups') ?></h4>
				<ul>
					<?php foreach($job->groups as $group): ?>
						<li><?= $this->Html->link( $group->title, [
							'controller' => "groups",
							'action' => 'manage',
							$group->group_id
						]) ?> (<?= number_format($group->member_count) ?> members)</li>
					<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<p><em><?= __('There are no groups assigned to this job') ?></em></p>
			<?php endif; ?>
			</div>
			</div>

			<div class="row">
			<div class="large-12 columns">
			<?php if( !empty( $job->tools ) ): ?>
				<h4><?= __('Tools') ?></h4>
				<table class="table table-bordered table-condensed">
				<tbody>
				<?php foreach($job->tools as $tool): ?>
				<tr>
					<td><?= h($tool->title) ?></td>
					<td><?= h($tool->_joinData->count) ?></td>
				</tr>
				<?php 
					if( isset($master_tools[ $tool->title ]) ) {
						$master_tools[ $tool->title ] += $tool->_joinData->count;
					} else {
						$master_tools[ $tool->title ] = $tool->_joinData->count;
					}
				endforeach; ?>
				</tbody>
				</table>
			<?php else: ?>
				<p><em><?= __('This job requires no tools') ?></em></p>
			<?php endif; ?>
			</div>
			</div>

			<hr>

		<?php endforeach; ?>

		<div class="row">
		<div class="large-12 columns">
		<?php if( count($master_tools) > 0 ): ?>
			<h2><?= __('Tool Totals') ?></h2>
			<table>
			<?php foreach($master_tools as $tool => $count): ?>
				<tr>
					<td><?= h($tool) ?></td>
					<td><?= number_format($count) ?></td>
				</tr>
			<?php endforeach; ?>
			</table>
		<?php else: ?>
			<p><em><?= __('Your Job Sites do not need any tools') ?></em></p>
		<?php endif; ?>
		</div>
		</div>

	<?php else: ?>

		<p><em><?= __('You currently do not have any job sites.') ?></em></p>
	<?php endif; ?>
	</div></div>
</main>
