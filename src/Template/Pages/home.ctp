<?php

use Cake\Core\Configure;

$this->layout = false;

$eventName = Configure::read('TheBigEvent.name');
$institutionName = Configure::read('TheBigEvent.institutionName');
$title = __("{0} at {1}", [
	$eventName,
	$institutionName
]);
?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
		<?= $title ?>
    </title>
	<?= $this->Html->meta('icon') ?>
	<?= $this->Html->css('base.css') ?>
	<?= $this->Html->css('cake.css') ?>
	<?= $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/css/foundation.min.css'); ?>
	<?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js'); ?>
	<?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js'); ?>
	<?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/js/foundation.min.js'); ?>
    <script>$(function () {
            $(document).foundation();
        });</script>
</head>
<body class="home">

<?= $this->Flash->render(); ?>
<?= $this->Flash->render('auth'); ?>

<header>
    <div class="header-image">
		<?= $this->Html->image('/img/thebigevent_main.png', [
			'alt' => $title
		]); ?>
        <h1 class="show-for-sr"><?= $title; ?></h1>

		<?php
		$jobsOpenDateTime = new \Cake\Chronos\Chronos(Configure::read('TheBigEvent.jobs.openDate'), $time_zone);
		$jobsCloseDateTime = new Cake\Chronos\Chronos(Configure::read('TheBigEvent.jobs.closeDate'), $time_zone);
		$now = new \Cake\Chronos\Chronos();
		$Jobs = \Cake\ORM\TableRegistry::get('Jobs');
		$jobCount = $Jobs->find()->count();
		$maxJobs = Configure::read('TheBigEvent.jobs.maxJobs');
		?>
		<? if (
		            $now->between($jobsOpenDateTime, $jobsCloseDateTime)
                &&  $jobCount < $maxJobs
        ): ?>
            <p class="append-top">
                <?= $this->Html->link("Submit a Job Request", [], [
                    "class" => "button button-uwyo-gold"
                ]); ?>
            </p>
		<?php else: ?>
            <p class="append-top">
                <?= __("Job Requests are currently closed. We look forward to serving you next year!") ?>
            </p>
		<?php endif; ?>
    </div>
</header>
<div id="content">
    <div class="row">
        <div class="columns medium-12">
			<?php
			$theBigEventDateTime = new \Cake\Chronos\Chronos(implode(" ", [
				Configure::read('TheBigEvent.event.date'),
				Configure::read('TheBigEvent.event.endTime')
			]), $time_zone);
			
			?>
            <h1 class="text-center">
                <?php if( $theBigEventDateTime->isPast() ): ?>
                    <?=
                    // TRANSLATORS: Tense select: "The Big Event was October 1, 2018"
                    h(__("{0} was {1}", [
                         $eventName,
                        $theBigEventDateTime->format('F j, Y')
                    ]) ); ?>
                <?php else: ?>
                    <?=
                    // TRANSLATORS: Tense: "The Big Event is October 1, 2018"
                    h(__("{0} is {1}", [
                        $eventName,
                        $theBigEventDateTime->format('F j, Y')
                    ])); ?>
                <?php endif; ?>
            </h1>
        </div>
    </div>
    <hr>
    <div class="row text-center">
        <div class="columns large-6">
            <H3>Student Volunteers</H3>
            <div class="row">
                <div class="columns large-6"><?= $this->Html->link(__('Register'), [
						'controller' => 'Users',
						'action' => 'login'
					], ['class' => 'button button-uwyo-gold button-block']) ?></div>
                <div class="columns large-6"><?= $this->Html->link(__('Login'), [
						'controller' => 'Users',
						'action' => 'login'
					], ['class' => 'button button-uwyo-gold button-block']) ?></div>
            </div>

            <p><?= __("Complete your profile and digitally sign participation documents."); ?></p>
            
        </div>
        <div class="columns large-6">
            <H3>Committee Access</H3>
			<?php echo $this->Html->link(__("Committee Login"), [
				'controller' => 'Users',
				'action' => 'login'
			], ['class' => 'button button-uwyo-gold button-block']); ?>

            <p><?= __("Help make {0} happen!", [$eventName]); ?></p>
        </div>
    </div>
    <div class="row clear">
        <div class="columns small-12">
            <div class="clearfix">
                <ul class="tabs" data-tab>
                    <li class="tab-title active"><a href="#panel-about">About</a></li>
                    <li class="tab-title"><a href="#panel-contact">Contact</a></li>
                </ul>
                <div class="tabs-content">
                    <div class="content active" id="panel-about">
                        <h2>About <?= $eventName; ?></h2>
                        <h3>Mission</h3>
                        <p>Through service-oriented activities, <?= $eventName; ?> promotes campus and community unity
                            as <?= Configure::read('TheBigEvent.institutionName'); ?> students come together for one day
                            to express their gratitude for the support from the surrounding community.</p>
                        <h3>History</h3>
                        <p><?= $eventName; ?> was founded at Texas A&amp;M University in 1982. Since
                            then, <?= $eventName; ?> has
                            expanded to over 100 schools across the country, all joining together in the spirit of
                            service. The first annual Big Event was held at the University of Wyoming in the fall of
                            2013 as the kick-off to homecoming week with just over 300 students participating. Now, in
                            our 6th year, we expect 1000 students to say "Thank You" to their community and participate
                            in <?= $eventName; ?>.</p>
                        <h3>Core Values</h3>
                        <p><?= $eventName; ?> strives to uphold the ideals of unity and service. This one-day event is
                            not
                            based on socioeconomic need, but rather is a way for the student body to express their
                            gratitude to the entire community which supports the university. It is important to remember
							<?= $eventName; ?> is not about the number of jobs completed or the number of students who
                            participate each year. Instead, it is the interaction between students and residents and the
                            unity that results throughout the community that makes <?= $eventName; ?> such a unique
                            project.</p>
                    </div>
                    <div class="content" id="panel-contact">
                        <h2>Contact Us</h2>
                        <p>If you have questions about <?= $eventName; ?>, please reach out!</p>
                        <dl>
                            <dt>Email</dt>
                            <dd>
                                <a href="mailto:<?= Configure::read('TheBigEvent.contact.email'); ?>">
                                    <?= Configure::read('TheBigEvent.contact.email'); ?>
                                </a>
                            </dd>
                            <dt>Phone</dt>
                            <dd><?= Configure::read('TheBigEvent.contact.phone'); ?></dd>
                            <dt>Address</dt>
                            <dd><?= implode('<br>', Configure::read('TheBigEvent.contact.address')); ?></dd>
                        </dl>
                    </div>
                </div>
            </div><!-- /.clearfix -->
        </div>
    </div>


</div>

<?= $this->Element('GoogleAnalytics'); ?>
</body>
</html>
