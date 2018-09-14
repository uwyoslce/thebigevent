<?php $this->layout = false; ?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
<title><?= __("Printing User Information") ?></title>
<style>
		.job {page-break-inside: avoid;}
</style>

</head>
<body onload="window.print()">
<div class="container">

<?php include(APP . "Template/Email/html/checked_in.ctp"); ?>

</div>
</body>
</html>