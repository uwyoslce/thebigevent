<?php
$eventName = \Cake\Core\Configure::read('TheBigEvent.name');
$kickoffVenueName = \Cake\Core\Configure::read('TheBigEvent.event.kickoffVenueName');
$kickoffStartTime = \Cake\Core\Configure::read('TheBigEvent.event.startTime');
$communityName = \Cake\Core\Configure::read('TheBigEvent.event.communityName');
$email = \Cake\Core\Configure::read('TheBigEvent.contact.email');
$date = \Cake\Chronos\Chronos( \Cake\Core\Configure::read('TheBigEvent.event.date') );
?>Thank you for registering to volunteer at <?= $eventName ?>! <?= $eventName ?>'s primary purpose is to say "thank you" to our <?= $communityName ?> community through service. We are excited that you will be joining in this day of giving back to our community that gives so much to us. A few things you need to know:

1. If you are registered as a group, there is a high likelihood that your group will be broken into smaller groups to accommodate the jobs for our community members and to ensure that each community member receives the help they need.

2. Volunteers will be receiving information leading up to the event regarding their assigned community member and site as well as any other important updates so please check your email.

3. Volunteers will be able to pick-up their shirt the two days leading up to the event in the Wyoming Union or on the day of the event.

4. <?= $eventName ?> Kick-Off will be held at <?= $kickoffVenueName ?> this year at <?= $kickoffStartTime ?>. Volunteers are asked to arrive on-time.

Please contact our staff at <?= $email ?> with any questions or concerns. We are looking forward to seeing you on <?= $date->format("F jS") ?>!
