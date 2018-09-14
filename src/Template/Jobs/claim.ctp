
<aside class="large-3 columns">
	<?= $this->Element('sidebar', ['user_role' => $AuthUser['role']]) ?>
</aside>
<main class="large-9 columns content">
	<div class="row">
		<div class="columns large-12">
			
	<h2>Claim Sites</h2>
	<p>If you claim a site, you will become its site leader.</p>
			<?php if( $jobs->count() > 0 ): ?>
				<table>
					<thead>
					</thead>
					<tbody>
					<?php foreach($jobs as $job): ?>
						<tr>
							<td><?= h($job->display_field) ?></td>
							<td><?= $this->Form->postLink('Claim as Site Leader', [
								'action' => 'claim',
								$job->job_id
							]); ?>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>

			<?php endif; ?>
		</div>
	</div>
</main>