<?php

$eventName = \Cake\Core\Configure::read('TheBigEvent.name');
$kickoffVenueName = \Cake\Core\Configure::read('TheBigEvent.event.kickoffVenueName');
$kickoffStartTime = \Cake\Core\Configure::read('TheBigEvent.event.startTime');
$communityName = \Cake\Core\Configure::read('TheBigEvent.event.communityName');
$email = \Cake\Core\Configure::read('TheBigEvent.contact.email');
$date = \Cake\Chronos\Chronos(\Cake\Core\Configure::read('TheBigEvent.event.date'));

?><p>Hello, <?php echo h($job->contact_first_name); ?>!</p>

<p>We have received your job request for <?= $eventName ?> on <?= $date->format("l, F j, Y") ?>.</p>

<p><strong>For reference, your job number is <?php echo h($job->job_id); ?>.</strong></p>

<p>Our team will be in touch soon to schedule a site visit. During this site visit, we will go over the job details and
    officially confirm your participation in <?= $eventName ?>.</p>

<p>If you have any concerns, give us a call at (307) 766-3117 or reply to this message!</p>

<p>We look forward to serving you!</p>

<p>Warmly,<br>
	<?= __("{0} at {1}", [
		\Cake\Core\Configure::read("TheBigEvent.name"),
		\Cake\Core\Configure::read("TheBigEvent.institutionName")
	]); ?></p>
