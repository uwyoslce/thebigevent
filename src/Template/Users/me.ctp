<?php
$eventName = \Cake\Core\Configure::read("TheBigEvent.name");
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</nav>
<div class="jobs view large-9 medium-8 columns content">

    <div class="row">

        <div class="column large-12 text-center">
            <div class="box box--uwyo-brown">
				<?php if ($user->participating): ?>
                    <i class="fa fa-check text-success fa-5x"></i>
                    <h2 class="">You are participating in <?= $eventName ?>!</h2>
                    <p>Stay connected to your email for more information leading up to <?= $eventName ?>!</p>
				<?php else: ?>
                    <i class="fa fa-question text-warning fa-5x"></i>
                    <h2 class="">Are you participating in <?= $eventName ?>?</h2>
                    <p>If you are participating in <?= $eventName ?>, click this button!</p>
                    <p><?= $this->Html->link(__("I am participating in {0}!", [$eventName]), ['action' => 'participate'], [
							'class' => 'button button-uwyo-gold'
						]) ?></p>
				<?php endif; ?>
            </div>
        </div>

        <div class="column large-12 text-center">
            <h2><?= __('Next Steps to Volunteer'); ?></h2>
        </div>

        <div class="column large-4 text-center">
            <h4>Complete your profile</h4>
            <p>
				<?= __('A completed profile will help {0} committee match you to the best job for you.', [$eventName]) ?>
            </p>
        </div>
        <div class="column large-4 text-center">
            <h4><?= __('Sign Participant Documents') ?></h4>
            <p>
				<?= __('Sign waivers and participant agreements online') ?>
            </p>
            <p><?= $this->Html->link(__("Sign Participation Documents"), ['action' => 'index', 'controller' => 'signatures'], [
					'class' => 'button small button-uwyo-gold'])
				?></p>
        </div>
        <div class="column large-4 text-center">
            <h4><?= __('Create or Join A Group (optional)') ?></h4>
            <p><?= __('Volunteer with friends or an on-campus group.') ?></p>
            <p><?= $this->Html->link(__("Create A Group"), ['action' => 'create', 'controller' => 'groups'], [
					'class' => 'button small button-uwyo-gold'
				]) ?> <?= $this->Html->link(__("Join A Group"), ['action' => 'join', 'controller' => 'groups'], [
					'class' => 'button small button-uwyo-gold'
				]) ?></p>

        </div>

    </div>
	
	<?= $this->Form->create($user) ?>
    <div class="row">
        <div class="column large-12">
            <h2>Update Your Profile</h2>
        </div>
        <div class="column large-5">
			<?= $this->Form->control('first_name'); ?>
        </div>
        <div class="column large-7">
			<?= $this->Form->control('last_name'); ?>
        </div>

        <div class="column large-12">
            <p>We use your name to personalize the site and address you in emails. Your name is also used for signing
                electronic documents.</p>
        </div>
        <div class="column large-12">
			<?= $this->Form->control('address_1') ?>
        </div>
        <div class="column large-12">
			<?= $this->Form->control('address_2') ?>
        </div>

        <div class="column large-6">
			<?= $this->Form->control('city') ?>
        </div>
        <div class="column large-3">
			<?= $this->Form->control('state') ?>
        </div>
        <div class="column large-3">
			<?= $this->Form->control('zip_code') ?>
        </div>


    </div>
    <div class="row">
        <div class="column large-6">
			<?= $this->Form->control('email') ?>
            <p>We may need to send important messages to you about <?= $eventName ?> via this email address.</p>
        </div>
        <div class="column large-6">
			<?= $this->Form->control('phone', ['class' => 'phone_mask']) ?>
            <p>Optional. We might use this to contact you with urgent information.</p>
        </div>
    </div>
    <div class="row">
        <div class="column large-6">
			<?= $this->Form->control('username'); ?>
            <p>You can change your username at any time. Our only rule is that it has to be unique.</p>
        </div>
        <div class="column large-6">
			<?= $this->Form->control('time_zone', [
				'options' => [
					"Pacific/Kwajalein" => "(GMT -12:00) Eniwetok, Kwajalein",
					"Pacific/Samoa" => "(GMT -11:00) Midway Island, Samoa",
					"Pacific/Honolulu" => "(GMT -10:00) Hawaii",
					"America/Anchorage" => "(GMT -9:00) Alaska",
					"America/Los_Angeles" => "(GMT -8:00) Pacific Time (US & Canada)",
					"America/Denver" => "(GMT -7:00) Mountain Time (US & Canada)",
					"America/Chicago" => "(GMT -6:00) Central Time (US & Canada), Mexico City",
					"America/New_York" => "(GMT -5:00) Eastern Time (US & Canada), Bogota, Lima",
					"Atlantic/Bermuda" => "(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz",
					"Canada/Newfoundland" => "(GMT -3:30) Newfoundland",
					"Brazil/East" => "(GMT -3:00) Brazil, Buenos Aires, Georgetown",
					"Atlantic/Azores" => "(GMT -2:00) Mid-Atlantic",
					"Atlantic/Cape_Verde" => "(GMT -1:00 hour) Azores, Cape Verde Islands",
					"Europe/London" => "(GMT) Western Europe Time, London, Lisbon, Casablanca",
					"Europe/Brussels" => "(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris",
					"Europe/Helsinki" => "(GMT +2:00) Kaliningrad, South Africa",
					"Asia/Baghdad" => "(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg",
					"Asia/Tehran" => "(GMT +3:30) Tehran",
					"Asia/Baku" => "(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi",
					"Asia/Kabul" => "(GMT +4:30) Kabul",
					"Asia/Karachi" => "(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent",
					"Asia/Calcutta" => "(GMT +5:30) Bombay, Calcutta, Madras, New Delhi",
					"Asia/Dhaka" => "(GMT +6:00) Almaty, Dhaka, Colombo",
					"Asia/Bangkok" => "(GMT +7:00) Bangkok, Hanoi, Jakarta",
					"Asia/Hong_Kong" => "(GMT +8:00) Beijing, Perth, Singapore, Hong Kong",
					"Asia/Tokyo" => "(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk",
					"Australia/Adelaide" => "(GMT +9:30) Adelaide, Darwin",
					"Pacific/Guam" => "(GMT +10:00) Eastern Australia, Guam, Vladivostok",
					"Asia/Magadan" => "(GMT +11:00) Magadan, Solomon Islands, New Caledonia",
					"Pacific/Fiji" => "(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka"
				]
			]); ?>
            <p>Our website will do its best to show you dates and times as they appear in your time zone.</p>
        </div>
        <div class="column large-4">
			<?= $this->Form->control('shirt_size', [
				'options' => [
					'?' => '(select a size)',
					'S' => 'Small',
					'M' => 'Medium',
					'L' => 'Large',
					'XL' => 'X-Large',
					'XXL' => 'XX-Large'
				],
				'default' => '?'
			]) ?>
            <p>
				<?= $eventName ?> t-shirts are available on a first-come-first-served basis.
                Letting us know your t-shirt size will help us order the right amount.
            </p>
        </div>
        <div class="column large-4">
			<?= $this->Form->control('transportation', [
				'options' => [
					'cannot_drive' => __("I cannot drive during {0}", [$eventName]),
					'can_drive' => __("I can drive during {0}", [$eventName]),
				],
				'default' => 'cannot_drive'
			]) ?>
            <p>Let us know your transportation situation.</p>
        </div>
        <div class="column large-4">
			<?= $this->Form->control('vehicle_capacity', [
				'default' => 0
			]); ?>
            <p>
                If you can drive, let us know how many people, including yourself, can fit into your vehicle.
                Enter <code>1</code> if you intend to be the only passenger in your vehicle.</p>
        </div>
        <div class="column large-12">
			<?= $this->Form->button('Save My Profile') ?>

        </div>
    </div>
	<?= $this->Form->end() ?>

</div>