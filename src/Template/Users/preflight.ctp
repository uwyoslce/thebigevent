<?php $this->layout = false; ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
<title><?= __("Previewing Preflight") ?></title>
<style>
		.job {page-break-inside: avoid;}
</style>

</head>
<body>
<div class="container">

<?php foreach($identities as $identity): ?>
<?php include(APP . "Template/Email/html/preflight.ctp"); ?>
<hr>
<?php endforeach; ?>

</div>
</body>
</html>