<aside class="large-3 column">
	<?php echo $this->Element( 'sidebar', [ 'user_role' => $AuthUser['role'] ] ); ?>
</aside>
<article class="large-9 columns content">

	<h2><?= __( 'Review and Sign {0}', [ $signature->document->title ] ) ?></h2>

	<p>
		<?php echo $this->Html->link( 
			__( 'Download {0}', [ $signature->document->title ] ),
			 $signature->document->path,
			 ['class' => 'button'] ) ?>
	</p>

	<p>Please enter your electronic signature below.</p>
	<p>Your electronic signature must exactly match <br><code><?php echo __( '/s/ {0} {1}', [
				strtoupper( trim($signature->user->first_name) ),
				strtoupper( trim($signature->user->last_name) )
			] ); ?></code></p>
	<p>Your electronic signature is case sensitive.</p>
	<?php echo $this->Form->create( $signature ); ?>
	<?php echo $this->Form->control( 'signature_text' ); ?>
	<?php echo $this->Form->button( 'Electronically Sign' ); ?>
	<?php echo $this->Form->end(); ?>
</article>
