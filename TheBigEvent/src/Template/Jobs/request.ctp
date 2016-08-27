<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Go Home'), "/") ?></li>
    </ul>
</nav>
<div class="jobs form large-9 medium-8 columns content">
    <?= $this->Form->create($job) ?>
    <h1>The Big Event: Job Site Request</h1>
    <p>Thank you for your interest in The Big Event!  Let us know what you need help with by filling out this form.  Once you submit the form, we will send you an email.</p>
    <fieldset>
        <legend><?= __('The Job Site') ?></legend>
        <?php
            echo $this->Html->tag(
                'p',
                "While we hope for nice weather for your outdoor tasks, we recommend picking a few indoor tasks for inclement weather.  If you don't have any indoor tasks, and we experience inclement weather, The Big Event will not send volunteers to your job site.",
                [
                    'id' => 'task_warning'
                ]
            );
            echo $this->Form->input('tasks._ids', [
                'label' => __('Select tasks'),
                'options' => $tasks,
                'required' => true
            ]);
            

            echo $this->Form->input('job_description');

            echo $this->Form->input('volunteer_count', [
                'label' => 'How many volunteers do you need?'
            ]);

            echo $this->Form->input('contact_address_1', [
                'label' => 'Job Site Address line 1']);
            echo $this->Form->input('contact_address_2', [
                'label' => 'Job Site Address line 2']);
            echo $this->Form->input('contact_city', [
                'type' => 'hidden',
                'label' => 'City',
                'value' => 'Laramie']);
            echo $this->Form->input('contact_state', [
                'type' => 'hidden',
                'value' => 'WY']);
            echo $this->Form->input('contact_zip', [
                'label' => 'ZIP Code']);

            
        ?>
    </fieldset>
    <fieldset>
        <legend>Your Contact Information</legend>
        <p>We may need to get ahold of you as we organize The Big Event. Please provide your contact information here.</p>
        <?php
            echo $this->Form->input('contact_first_name', [
                'label' => 'First Name']);
            echo $this->Form->input('contact_last_name', [
                'label' => 'Last Name']);
            echo $this->Form->input('contact_phone', [
                'label' => 'Phone Number']);
            echo $this->Form->input('contact_email', [
                'label' => 'Email Address']);
            echo $this->Form->input('contact_best_time_to_call', [
                'label' => "Best Time To Call",
                'options' => [
                    'morning' => 'Morning (before noon)',
                    'afternoon' => 'Afternoon (before 5 PM)',
                    'evening' => 'Evenings (after 5 PM'
                ]]);
            echo $this->Form->input('referral', [
                'label' => __("How did you hear about The Big Event?"),
                'options' => [
                    'boomerang'        => 'The Laramie Boomerang',
                    'media'     => 'Radio/Television',
                    'internet'  => 'Web Site',
                    'social'    => 'Facebook/Twitter/Social Media',
                    'person'    => 'Personal Referral',
                    'utility'   => 'City of Laramie Water/Utility Bill',
                    'mailer'    => 'Mailer',
                    'other'     => 'Other',
                ]
            ]);
        ?>
    </fieldset>
    <fieldset>
        <legend>Agreements</legend>
        <p>Please read and agree to the following.</p>
        <ul>
            <?php foreach([
                'I understand that under no circumstance will students use power tools or drive property owner’s vehicles during service project.',
                'I understand that as the property owner, I must be present during the service and that if I am not, the job cannot be completed.',
                'I understand that The Big Event and The University of Wyoming are under no obligation to provide or dispatch volunteers to my job site.',
                'I understand that in the event of inclement weather, only indoor jobs will be completed.'
            ] as $agreement): ?>
                <li><?php echo h($agreement); ?></li>
            <?php endforeach; ?>   
        </ul>

        <?php echo $this->Form->input('accepted_agreements', ['label' => 'I have read and accept these agreements.']); ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
