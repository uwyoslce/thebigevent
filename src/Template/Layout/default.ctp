<?php

use Cake\Core\Configure;

$cakeDescription = __("{0} at {1}", [
	Configure::read('TheBigEvent.name'),
	Configure::read('TheBigEvent.institutionName')
]);

function

getJSONconst($name, $toSerialize) {
    return sprintf("const %s = %s;",
        $name,
        json_encode($toSerialize)
    );
}
?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
		<?= $cakeDescription ?>:
		<?= $this->fetch('title') ?>
    </title>
	<?= $this->Html->meta('icon') ?>
	
	<?= $this->Html->css('base.css?ver=20160931') ?>
	<?= $this->Html->css('cake.css?ver=20160931') ?>
	<?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js'); ?>
	<?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.5/angular.js'); ?>
	<?= $this->Html->script('//cdn.jsdelivr.net/npm/places.js@1.9.0'); ?>
	<?= $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'); ?>
	<?= $this->Html->script('thebigevent.js?ver=20160931'); ?>
	
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>

    
    <?= $this->Html->scriptBlock( getJSONconst('global', [
            'root' => $this->Url->build('/', true)
    ]), ['defer' => true] ) ?>
</head>
<body>
<nav class="top-bar expanded no-print" data-topbar role="navigation">
    <ul class="title-area large-3 medium-4 columns">
        <li class="name">
            <h1><a href="/users/me"><?= Configure::read('TheBigEvent.name') ?></a></h1>
        </li>
    </ul>
    <div class="top-bar-section">
        <ul class="right">
			<?php if (null != $AuthUser) : ?>
				<?php $user = $AuthUser; ?>
                <li><?php echo $this->Html->link('Logout @' . $user['username'], [
						'controller' => 'Users',
						'action' => 'logout']); ?></li>
			<?php else: ?>
                <li><?php echo $this->Html->link('Login', [
						'controller' => 'Users',
						'action' => 'login']); ?></li>
			<?php endif; ?>
			<?php foreach (Configure::read('TheBigEvent.headerLinks') as $link): ?>
                <li><?= $this->Html->link($link['label'], $link['link'], ['target' => '_blank']) ?></li>
			<?php endforeach; ?>
        </ul>
    </div>
</nav>
<?= $this->Flash->render() ?>
<?= $this->Flash->render('auth') ?>
<div class="container clearfix">
	<?= $this->fetch('content') ?>
</div>
<footer>
</footer>
<?= $this->Element('GoogleAnalytics') ?>
</body>
</html>
