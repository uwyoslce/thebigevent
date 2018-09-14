<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

$cakeDescription = 'The Big Event at The University of Wyoming';
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/css/foundation.min.css'); ?>
    <?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js'); ?>
    <?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js'); ?>
    <?= $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/js/foundation.min.js'); ?>
    <script>$(function(){
        $(document).foundation();
    });</script>
</head>
<body class="home">

    <?= $this->Flash->render() ?>
    <?= $this->Flash->render( 'auth' ) ?>
    
    <header>
        <div class="header-image">
            <?= $this->Html->image('/img/thebigevent_main.png', [
                'alt' => "The Big Event at The University of Wyoming"
                ]) ?>
            <h1 class="show-for-sr">The Big Event</h1>
            
		<!-- <p class="append-top">Job Request are currently closed.  We look forward to serving you next year!</p>-->
		<p class="append-top"><a href="/jobs/request" class="button button-uwyo-gold">Submit a Job Request</a></p>
        </div>
    </header>
    <div id="content">
        <div class="row">
            <div class="columns medium-12">
                <h1 class="text-center">The Big Event is October 13, 2018</h1>
            </div>
        </div>
        <hr>
        <div class="row text-center">
            <div class="columns large-6">
                <H3>Student Volunteers</H3>
                <div class="row">
                    <div class="columns large-6"><?= $this->Html->link( __('Register'), [
                    'controller' => 'Users',
                    'action' => 'login'
                ], ['class' => 'button button-uwyo-gold button-block']) ?></div>
                    <div class="columns large-6"><?= $this->Html->link( __('Login'), [
                    'controller' => 'Users',
                    'action' => 'login'
                ], ['class' => 'button button-uwyo-gold button-block']) ?></div>
                </div>
                
                <p>Complete your profile and digitially sign participation documents.</p>
            </div>
            <div class="columns large-6">
                <H3>Committee Access</H3>
                <?php echo $this->Html->link(__("Committee Login"), [
                    'controller' => 'Users',
                    'action' => 'login'
                ],['class' => 'button button-uwyo-gold button-block'])?>

                <p>Help make The Big Event happen!</p>
            </div>
        </div>
        <div class="row clear">
            <div class="columns small-12">
                <div class="clearfix">
                    <ul class="tabs" data-tab>
                      <li class="tab-title active"><a href="#panel-about">About</a></li>
                      <li class="tab-title"><a href="#panel-contact">Contact</a></li>
                    </ul>
                    <div class="tabs-content">
                      <div class="content active" id="panel-about">
                        <h2>About The Big Event</h2>
                        <h3>Mission</h3>
                        <p>Through service-oriented activities, The Big Event promotes campus and community unity as University of Wyoming students come together for one day to express their gratitude for the support from the surrounding community.</p>
                        <h3>History</h3>
                        <p>The Big Event was founded at Texas A&amp;M University in 1982. Since then, The Big Event has expanded to over 100 schools across the country, all joining together in the spirit of service. The first annual Big Event was held at the University of Wyoming in the fall of 2013 as the kick-off to homecoming week with just over 300 students participating. Now, in our 4th year, we expect 1000 students to say "Thank You" to their community and participate in The Big Event.</p>
                        <h3>Core Values</h3>
                        <p>The Big Event strives to uphold the ideals of unity and service. This one-day event is not based on socioeconomic need, but rather is a way for the student body to express their gratitude to the entire community which supports the university. It is important to remember The Big Event is not about the number of jobs completed or the number of students who participate each year. Instead, it is the interaction between students and residents and the unity that results throughout the community that makes The Big Event such a unique project.</p>
                      </div>
                      <div class="content" id="panel-contact">
                        <h2>Contact Us</h2>
                        <p>If you have questions about The Big Event, please reach out!</p>
                        <dl>
                            <dt>Email</dt>
                            <dd><a href="mailto:bigevent@uwyo.edu">bigevent@uwyo.edu</a></dd>
                            <dt>Phone</dt>
                            <dd>(307) 766-3117</dd>
                            <dt>Address</dt>
                            <dd>1000 E. University Ave<br>
                                Dept 3625<br>
                                Laramie, WY 82071</dd>
                        </dl>
                      </div>
                    </div>
                </div><!-- /.clearfix -->
            </div>
        </div>

        
    </div>
    
    <?= $this->Element('GoogleAnalytics') ?>
</body>
</html>
