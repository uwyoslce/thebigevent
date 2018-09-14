<p>Hello, <?= h($identity->user->full_name) ?>!</p>

<p>You are checked in for The Big Event.  Please find the members of your group, pick up your tools from your site leader (listed below) listen for further instructions before heading to your job site.</p>

<?php if( empty( $identity->user->signatures) ): ?>

<?php else: ?>

<?php endif; ?>

<?php if( empty( $identity->user->groups) ): ?>
    <p>You have not been assigned a volunteer group at this time.  Please find the overflow area to receive a group assignment.</p>
<?php else: ?>
    <?php foreach($identity->user->groups as $group): ?>
        <?php if( empty( $group->jobs) ): ?>
            <p><em>Your group has not been assigned a job site at this time. Please find the overflow area to receive a job assignment.</em></p>
        <?php else: ?>
            <?php foreach($group->jobs as $job): ?>
                <h2>Job <?= $job->job_id ?> Details</h2>
                <p>You will be volunteering for <?= h($job->contact_first_name) ?> <?= h($job->contact_last_name) ?>.  Here is the address:</p>

                <p>
                    <strong><?= h($job->contact_first_name) ?> <?= h($job->contact_last_name) ?></strong><br>
                    <?= h($job->contact_address_1) ?><br>
                    <?php if($job->contact_address_2 != "") : ?>
                    <?= h($job->contact_address_2) ?><br>
                    <?php endif; ?>
                    <?= h($job->contact_city)?>, <?= h($job->contact_state)?> <?= h($job->contact_zip)?>
                </p>

                <h3>Your Site Leader</h3>

                <p><strong>Pick up tools, and check in with your site leader at the <?= h($job->site_leader->color) ?> Table.</strong></p>

                <p>
                    <strong><?= h($job->site_leader->first_name) ?> <?= h($job->site_leader->last_name) ?></strong><br>
                    <?= h($job->site_leader->phone) ?><br>
                    <?= h($job->site_leader->email) ?><br>
                    
                </p>
                
                <p>You can contact your Site Leader, <?= h($job->site_leader->first_name) ?>, with any questions, problems or concerns regarding your service project.</p>

                <h2>Your Group</h2>
                <p>Here is contact information for all members of your group.  Use this information to help your group communicate, meet up, and arrange transportation.</p>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Can Drive?</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php foreach($group->users as $member): ?>
                    <tr>
                        <td><?= h($member->full_name) ?></td>
                        <td><?= h($member->email) ?></td>
                        <td><?= h($member->phone) ?></td>
                        <td>
                            <?php if( $member->transportation == "can_drive"  && $member->vehicle_capacity > 1 ): ?>
                                <em>Yes, up to <?= number_format($member->vehicle_capacity, 0) ?> people.</em>
                            <?php else: ?>
                                <em>No</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        <?php endif; ?>

    <?php endforeach; ?>
<?php endif; ?>

<h2>Safety Reminders</h2>
<ul>
    <li>Do not, under any circumstances, use power tools during your visit to your job site.</li>
    <li>Do not, under any circumstances, use a ladder during your visit to your job site.</li>
    <li>Do not, under any circumstances, drive a vehicle belonging to the job site owner.</li>
</ul>

<h2>When you're done at your job site...</h2>
<p>If you're done well in advance of 1 PM, call your Site Leader to see if there are other jobs that could use your help.</p>

<p>At 1 PM, please join Laramie Main Street, the UW Sustainability Club and UW SLCE at the Laramie Train Depot after The Big Event for a community volunteer appreciation BBQ with free food (courtesy of Ridley's and the AGR Fraternity) with live, solar powered music by...</p>

<ul>
    <li>Wood Belly, 11:30 - 12:30</li>
    <li>Whippoorwill, 12:45- 1:45</li>
    <li>Tallgrass, 2-3</li>
</ul>

<p><strong>BONUS:</strong> Altitude has brewed a special "Big Thanks Brown" that will be avaliable for sale with proceeds benefiting SLCE!</p>

<p>From all of us at The Big Event, we sincerely thank you for being part of today.</p>

<p>Sincerely,<br>
The Big Event at The University of Wyoming</p>