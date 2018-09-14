<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>

	    <li><?= $this->Html->link(
			    __('Print Job'),
			    ['action' => 'printing', $job->job_id]
		    )
		    ?></li>


		<li><?= $this->Form->postLink(
			__('Delete Job'),
			['action' => 'delete', $job->job_id],
			['confirm' => __('Are you sure you want to delete # {0}?', $job->job_id)]
		)
		?></li>

    </ul>
	    <?php echo $this->Element(
	    	'sidebar', ['user_role' => $AuthUser['role']]); ?>
</nav>

<div class="jobs form large-9 medium-8 columns content">

	<?= $this->Form->create($job) ?>
    <div class="row">
	    <div class="column large-12">
		    <h2>
			    <small><?= __("Editing") ?></small><br>
			    <?= h($job->display_field); ?></h2>
	    </div>
	</div>
	<div class="row">
	    <div class="column large-6">
	    	<h3>Site Leader</h3>
	    	<?= $this->Form->control('site_leader_id', [
	    		'options' => $site_leaders, 
	    		'empty' => true, 'selected' => $job->site_leader_id]); ?>

	    </div>
	    <div class="column large-6">
	    	<h3>Group Assignments</h3>
	    	<?php if( $job->has('groups')  && count($job->groups) > 0 ): ?>
	    			
	    		<table>
	    			<thead>
	    				<tr>
	    					<th>Group Name</th>
	    					<th>Members</th>
	    				</tr>
	    			</thead>
	    		<?php foreach($job->groups as $group): ?>
	    		<tr>
	    			<td><?= $this->Html->link( $group->title, [
	    			'controller' => 'Groups',
	    			'action' => 'manage',
	    			$group->group_id
	    		]) ?></td>
	    			<td>
	    				<?= number_format($group->member_count) ?>
	    			</td>
	    		</tr>
	    		<?php endforeach; ?>
	    		</table>
	    	<?php else: ?>
	    		<p><?= __('This job currently has no groups assigned'); ?></p>
	    	<?php endif; ?>
	    </div>
	</div>
	<div class="row">
		<div class="column large-12">

	    	<h3>Site Contact Info</h3>
	    </div>
	    <div class="column large-6">
			<div class="row">
				<div class="column large-5"><?php echo $this->Form->control('contact_first_name'); ?></div>
				<div class="column large-7"><?php  echo $this->Form->control('contact_last_name'); ?></div>
			</div>
		    <div class="row">
			    <div class="column large-12">
				    <?php echo $this->Form->control('contact_address_1'); ?>
			    </div>
		    </div>
		    <div class="row">
			    <div class="column large-12">
				    <?php echo $this->Form->control('contact_address_2'); ?>
			    </div>
		    </div>
		    <div class="row">
			    <div class="column large-4">
				    <?php echo $this->Form->control('contact_city'); ?>
			    </div>
			    <div class="column large-4">
				    <?php echo $this->Form->control('contact_state'); ?>
			    </div>
			    <div class="column large-4">
				    <?php echo $this->Form->control('contact_zip'); ?>
			    </div>
		    </div>
	    </div>
	    <div class="column large-6">
			<?php
		        echo $this->Form->control('contact_phone');
		        echo $this->Form->control('contact_email');
				echo $this->Form->control('contact_best_time_to_call');
				echo $this->Form->control('volunteer_count');
		    ?>
	    </div>
    </div>
	<div class="row">
		<div class="column large-4">
			<?php echo $this->Form->control('job_description'); ?>
		</div>
		<div class="column large-8">

			<?php echo $this->Form->control('notes'); ?>
		</div>
	</div>
	<div class="row">

		<div class="column large-4">
			<div class="conditions">
				<div class="conditions__data">
				<h3><?php echo __("Job Conditions"); ?></h3>
				<?php
				echo $this->Form->select('conditions._ids', $conditions, [
					'multiple' => 'checkbox'
				]);
				?>
				</div>
				<?php if( $AuthUser['role'] == "admin" ): ?>
					<div class="conditions__actions">
						<p>
							<?php echo $this->Html->link(__("Add A Condition"),[
								'controller' => 'Conditions',
								'action' => 'add'
							],
							[
								'class' => 'conditions__add'
							]

							); ?>
						</p>
					</div>
				<?php endif; ?>
			</div>

		</div>

		<div class="column large-4">
			<?php
				$existing_tools = array_map(function($tool){
					return [
						'title' => $tool->title,
						'tool_id' => $tool->tool_id,
						'count' => $tool->_joinData->count
					];
				}, $job->tools);
				$new_tools = array_map(function($title, $tool_id){
					return [
						'title' => $title,
						'tool_id' => $tool_id,
						'count' => 0
					];
				}, $tools->toArray(), array_keys($tools->toArray()));

				$completed_tools = array_merge($existing_tools, $new_tools);


			?>
			<div class="tools">
				<h3>Tools</h3>
				<div class="tools__data">
				<?php
				$i = 0;
				foreach( $completed_tools as $tool ): ?>
					<div class="row tool">
						<div class="column large-8 tool__title">
							<?= h( $tool['title'] ); ?>
						</div>
						<div class="column large-4 tool__count">
							<?php echo $this->Form->control("tools.$i.tool_id", [
								'value' => $tool['tool_id'],
								'type' => 'hidden'
							]); ?>
							<?php echo $this->Form->control("tools.$i._joinData.count", [
								'value' => $tool['count'],
								'label' => false,
								'type' => 'number'
							]); ?>
						</div>
					</div>

					<?php $i++;
				endforeach; ?>
				</div>

				<?php if( $AuthUser['role'] == "admin" ): ?>
					<div class="tools__actions">
						<p>
							<?php echo $this->Html->link(__('Create a Tool'), [
								'controller' => 'tools',
								'action' => 'add'
							],[
								'class' => 'tools__add'
							]); ?>
						</p>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="column large-4">
			<h3>Tasks</h3>
			<?php
			echo $this->Form->select('tasks._ids', $tasks, [
				'multiple' => 'checkbox'
			]);
			?>
		</div>
	</div>

    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>

</div>
