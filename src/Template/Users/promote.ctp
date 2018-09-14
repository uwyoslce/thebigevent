<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<ul class="side-nav">
		<li class="heading"><?= __( 'Actions' ) ?></li>

		<?php if ( 'admin' == $AuthUser['role'] ) : ?>
			<li><?= $this->Html->link(
					__( 'View My Profile' ),
					[ 'action' => 'me' ]
				)
				?></li>
		<?php endif; ?>

	</ul>
	<?php echo $this->Element( 'sidebar', [ 'user_role' => $AuthUser['role'] ] ); ?>
</nav>
<section class="large-9 medium-8 columns content">

	<?= $this->Form->create('User') ?>
		<h2><?= __('Promote a User'); ?></h2>
		<p>Use this form to give an existing user a new role.  After you update the user, the user must log out to see the changes.</p>
		<?= $this->Form->control('user_id', ['options' =>$users, 'label' => "User"]); ?>
		<?= $this->Form->control('role', [ 'options' => [
			'admin' => 'Administrator',
			'committee' => 'Committee Member',
			'volunteer' => 'Volunteer'
		], 'label' => 'Role']); ?>
		<?= $this->Form->button('Set User Role') ?>
	<?= $this->Form->end(); ?>

</section>