<?php $this->layout = false; ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
<title><?= __("Printing Job Sheets") ?></title>
<style>
		.job {page-break-inside: avoid;}
</style>

</head>
<body>
<div class="container">
<?php foreach( $jobs as $job ): ?>
<?php for($i = 0; $i < $job->volunteer_count; $i++): ?>
	<article class=" job">
		<table class="table table-condensed">
		<tr>
		<td class="">
			<p>
				<strong><?= $job->contact_first_name ?> <?= $job->contact_last_name ?></strong><br>
				<?= $job->contact_address_1 ?><br>
				<?php if( !empty( trim( $job->contact_address_2 ) ) ) : ?>
					<?= $job->contact_address_2 ?><br>
				<?php endif; ?>
				<?= $job->contact_city ?>, <?= $job->contact_state ?> <?= $job->contact_zip ?>
			</p>
			<?= $this->Text->autoParagraph( $job->job_description ) ?>
		</td>
		<td class="text-right">
			<p><strong><?= $job->volunteer_count; ?> volunteers</strong></p>
			<?php if( !empty($job->conditions) ): ?>
			<p><strong>Vehicle Transportation Required</strong></p>
			<?php endif; ?>
			<p>
				<strong><?= $job->site_leader->first_name ?> <?= $job->site_leader->last_name ?></strong><br>
				<?= $job->site_leader->email ?>
				<?php if( !empty($job->site_leader->phone) ): ?>
					<br><?= $job->site_leader->phone ?>
				<?php endif; ?>
			</p>
		</td>
		</tr>
		</table>
			<?php if( !empty($job->tools) ): ?>
				<h5>Tools</h5>
				<table class="table table-bordered table-condensed table-compact">
					<?php foreach($job->tools as $tool): ?>
					<tr>
						<td><?= $tool->title ?></td>
						<td><?= $tool->_joinData->count ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<p><em>This job doesn't require any tools</em></p>
			<?php endif; ?>
	</article>
<?php endfor; ?>
<?php endforeach; ?>
</div>
</body>
</html>
