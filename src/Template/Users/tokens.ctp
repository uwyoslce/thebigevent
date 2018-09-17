<nav class="large-3 medium-4 columns" id="actions-sidebar">
	<?php echo $this->Element('sidebar', ['user_role' => $AuthUser['role']]); ?>
</nav>
<div class="jobs view large-9 medium-8 columns content">
	<h1><?php echo __("Identities") ?></h1>
	<p>These are identities that are associated with your account.  They allow you to authenticate and access
		<?= \Cake\Core\Configure::read("TheBigEvent.name") ?> data in a variety of ways.
	</p>
	<p>
		<?php echo $this->Form->postLink("New API Key") ?>
	</p>
	<?php if ($identities) {?>
		<?php foreach ($identities as $identity): ?>
			<?php if ($identity->protocol == "cas"): ?>
				<div class="card">
					<h3><?=h($identity->identifier) ?> via <?=h($CAS['name'])?></h3>
					<p>Can be used to login to <?= \Cake\Core\Configure::read("TheBigEvent.name") ?> via Single Sign-On with <?=h($CAS['name'])?>.</p>
					<div class="key-value-pairs">
						<div class="key-value-pairs__key-value-pair">
							<span class="key-value-pairs__key-value-pair__key">Created</span>
							<span class="key-value-pairs__key-value-pair__value">
								<?=h($identity->created->nice($AuthUser['time_zone'])) ?>
							</span>
						</div>
					</div>
				</div>
			<?php endif;?>

			<?php if ($identity->protocol == "bearer"): ?>
				<div class="card">
					<h3>API Key</h3>
					<p>Can be used to communicate via API at <code><?=$this->Url->build('/api', true)?></code></p>
					<p><code><?=$identity->identifier?></code></p>
					<h4> Sample Request </h4>
					<textarea rows="5">GET /api/users/me
Authorize: Bearer <?= $identity->identifier ?> 
Accept: application/json
Host: <?= $_SERVER['SERVER_NAME'] ?></textarea>
					<div class="key-value-pairs">
						<div class="key-value-pairs__key-value-pair">
							<span class="key-value-pairs__key-value-pair__key">Created</span>
							<span class="key-value-pairs__key-value-pair__value"><?=$identity->created->nice($AuthUser['time_zone'])?></span>
						</div>
					</div>
				</div>
			<?php endif;?>
		<?php endforeach;?>

	<?php } else {?>

	<?php }?>
</div>