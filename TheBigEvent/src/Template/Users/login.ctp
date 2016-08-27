<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
    </ul>
</nav>
<div class="jobs view large-9 medium-8 columns content">
	<div class="users form">
	<?= $this->Flash->render('auth') ?>
	<?= $this->Form->create() ?>
	<p><?= $this->Html->link(
		__('Login with {0}', [Cake\Core\Configure::read('CAS.name')] ),
		['action' => 'cas']
	) ?></p>
	    <fieldset>
	        <legend><?= __('Please enter your username and password') ?></legend>
	        <?= $this->Form->input('username') ?>
	        <?= $this->Form->input('password') ?>
	        <?= $this->Form->hidden('tzOffset', ['class' => 'tzOffset']) ?>
	    </fieldset>
	<?= $this->Form->button(__('Login')); ?>
	<?= $this->Form->end() ?>
	</div>
</div>