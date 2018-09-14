<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'The Big Event';
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

	<script>
		const globals = <?php echo json_encode([
			'root' => $this->Url->build('/', true)
		]); ?>;
	</script>
</head>
<body>
    <nav class="top-bar expanded no-print" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href="/users/me">The Big Event</a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <?php if( null != $AuthUser ) : ?>
                    <?php $user = $AuthUser; ?>
                    <li><?php echo $this->Html->link('Logout @' . $user['username'], [
                        'controller' => 'Users', 
                        'action' => 'logout']); ?></li>
                <?php else: ?>
                    <li><?php echo $this->Html->link('Login', [
                        'controller' => 'Users', 
                        'action' => 'login']); ?></li>
                <?php endif; ?>
                <li><a target="_blank" href="http://www.uwyo.edu">University of Wyoming</a></li>
                <li><a target="_blank" href="http://www.uwyo.edu/slce">SLCE</a></li>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <?= $this->Flash->render( 'auth' ) ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
    <?= $this->Element('GoogleAnalytics') ?>
</body>
</html>
