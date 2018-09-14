
<?php if( empty($jobs) ): ?>

<?php else: ?>
<table>
	<thead>
		<tr>
			<td>Actions</td>
			<td>ID</td> 
			<?php if( 'admin' == $AuthUser['role'] ): ?>
			<td>SL Dashboard</td>
			<td>SL Slips</td>
			<?php endif; ?>
			<td>SL Name</td>
			<td>Last Name</td>
			<td>First Name</td>
			<td>Phone</td>
			<td>Address 1</td>
			<td>Address 2</td>
			<td>City</td>
			<td>State</td>
			<td>Zip</td>
			<td>Volunteer Count</td>
			<td>Todos Incomplete</td>
			<td>Todos Complete</td>
		</tr>
	</thead>
<?php foreach( $jobs as $job ): ?>
	<tr>
		<td><?= $this->Html->link(__('View/Edit'), ['action' => 'edit', $job->job_id]) ?></td>
		<td><?= $job->job_id ?></td>
		<?php if( 'admin' == $AuthUser['role'] ): ?>
		
			<?php if( $job->site_leader ): ?>

				<td><?= $this->Html->link( __('View Dashboard'), ['controller' => 'Users', 'action' => 'sites', $job->site_leader->user_id] ); ?></td>
				<td><?= $this->Html->link(__('View Job Slips'), ['controller' => 'jobs', 'action' => 'printing', $job->site_leader->user_id])?></td>
				
			<?php else: ?>
				<td>&mdash;</td>
				<td>&mdash;</td>
				
			<?php endif; ?>

		<?php endif; ?>

		<?php if( $job->site_leader ): ?>
			<td><?= $job->site_leader->full_name ?></td>
		<?php else: ?>
			<td>&mdash;</td>
		<?php endif; ?>
		<td><?= $job->contact_last_name ?></td>
		<td><?= $job->contact_first_name ?></td>
		<td><?= $job->contact_phone ?></td>
		<td><?= $job->contact_address_1 ?></td>
		<td><?= $job->contact_address_2 ?></td>
		<td><?= $job->contact_city ?></td>
		<td><?= $job->contact_state ?></td>
		<td><?= $job->contact_zip ?></td>
		<td><?= $job->volunteer_count ?></td>
		<td><?= $job->todos_incomplete ?></td>
		<td><?= $job->todos_complete ?></td>
	</tr>

<?php endforeach; ?>
</table>
<?php endif; ?>
