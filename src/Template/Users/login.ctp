
<div class="jobs view large-12 medium-8 columns content">
	<div class="users form">

		<div class="text-center">
			<div><i class="fa fa-lock fa-5x" alt="lock icon"></i></div>
			<h3><?= __("Please Login To Access {0}", [ Cake\Core\Configure::read( 'TheBigEvent.name' ) ] ) ?></h3>
			<p><?= __("You must have an account with {0} to login.", [ Cake\Core\Configure::read( 'CAS.name' ) ] ) ?></p>
			<?= $this->Html->link(
				__( 'Login with {0}', [ Cake\Core\Configure::read( 'CAS.name' ) ] ),
				[ 'action' => 'cas' ],
				['class' => 'button button-uwyo-gold']
			) ?>
		</div>
	</div>
</div>