<div class="key-value-pairs">

	<?php foreach( $pairs as $pair_key => $pair_value): ?>

		<div class="key-value-pairs__key-value-pair">
			<span class="key-value-pairs__key-value-pair__key"><?= h($pair_key); ?></span>
			<span class="key-value-pairs__key-value-pair__value"><?php if( is_array($pair_value) ){
				echo implode(' ', $pair_value);
			} else {
				echo h($pair_value);
			} ?></span>
		</div>

	<?php endforeach; ?>

</div>