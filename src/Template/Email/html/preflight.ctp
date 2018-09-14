<p>Hello, <?= $identity->user->full_name ?>!</p>

<p>The Big Event is tomorrow, October 13, 2018 beginning at 9:00 AM.</p>

<h2>Tomorrow Morning</h2>
<p><strong>You must come to the kickoff event tomorrow morning.</strong>  The Kickoff Event is at 9:00 AM in Simpson's Plaza (outside the Union).</p>

<p>There will be coffee, hot chocolate, breakfast sandwiches, snacks to take with you, free t-shirts, tool pickup, safety instructions and more.  For safety reasons, we are unable to provide the location of your job site until you check in at the kickoff event.</p>

<h2>Quick Checkin</h2>
<p>Quickly check in at The Big Event kickoff event tomorrow morning by presenting this barcode at the checkin table. Show it to us on your phone, or print it out.</p>

<?php if( $qr_source == "attachment" ) : ?>
    <img src="cid:<?= $identity->identifier ?>" style="width:2in;height2in;">
<?php else: ?>
    <img src="<?= __('https://api.qrserver.com/v1/create-qr-code/?data={0}&size={1}x{1}&ecc={2}&qzone={3}&format={4}', [
						urlencode($identity->identifier), // data
						300, // size
						"M", // error correction
						5, // quiet zone (in units of image blocks)
						'png' // file format
					]) ?>" style="width:2in;height2in;">
<?php endif; ?>

<?php if( $identity->user->participating ) : ?>
    <h2>Participation Documents</h2>
    <?php if( $identity->user->signatures_unsigned > 0 ) : ?>
        <p><strong>You have unsigned participation documents.</strong>  Log in to your profile and click "Sign Documents" to electronically sign documents so you don't have to do it tomorrow.</p>
        <p><a href="https://uwyobigevent.com/users/login">Login and Sign Participation Documents</a></p>
    <?php else: ?>
        <p>You have signed all of your participation documents.</p>
    <?php endif; ?>
<?php else: ?>
    <p>Although you have not marked yourself as participating, you can still participate by showing up tomorrow.  Simply bring this email and we'll help you get checked in and up to speed.</p>
<?php endif; ?>

<h2>Job and Group Information</h2>
<?php if( empty($identity->user->groups) ) : ?>
    <p>You do not have a group assignment at this time.  Your group assignment will occur tomorrow at the kickoff event.</p>
<?php else: ?>
    <?php foreach($identity->user->groups as $group): ?>
        <?php if( empty($group->jobs) ): ?>
            <p>Your group does not have a job assignment at this time.  You will receive your job assignment at the kickoff event.</p>
        <?php else: ?>
            <?php foreach($group->jobs as $job): ?>
                <h3>Job <?= $job->job_id ?> Preview</h3>
                <p>You have been assigned to Job <?= $job->job_id ?>.  You and your group will be working for a community member named <?= h($job->contact_first_name) ?> <?= h($job->contact_last_name) ?>.  Here's a little preview of what you'll be doing on this project...</p>
                <?= Cake\View\Helper\TextHelper::autoParagraph($job->job_description); ?>

                <h3>Site Leader</h3>
                <p>After you checkin tomorrow, you need to meet your site leader at the <strong><?= h($job->site_leader->color) ?> table</strong>.  This is where you will pick up any tools or extra instruction before heading to your job site.</p>
                <p>
                    <strong><?= h($job->site_leader->first_name) ?> <?= h($job->site_leader->last_name) ?></strong><br>
                    <?= h($job->site_leader->phone) ?><br>
                    <?= h($job->site_leader->email) ?>
                </p>
                <p>You can contact your Site Leader, <?= h($job->site_leader->first_name) ?>, with any questions, problems or concerns regarding your service project.</p>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<p>Thank you for being a part of The Big Event! We'll see you tomorrow at 9:00 AM.</p>

<p>Sincerely,<br>
The Big Event at The University of Wyoming</p>
