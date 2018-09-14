<?php if( null == $user ) : ?>

<?php else : ?>
	<h2>Hello, <?= $user['user'] ?></h2>
	<?php if( !empty($user['attributes']) ): ?>
		<dl>
		<?php foreach( $user['attributes'] as $attribute => $value ): ?>
			<dt><?= h($attribute) ?></dt>
			<dd><?= h($value) ?></dt>
		<?php endforeach; ?>
		</dl>
	<?php else: ?>
		<p><em>CAS didn't provide any information about you.</em></p>
	<?php endif; ?>
<?php endif; ?>