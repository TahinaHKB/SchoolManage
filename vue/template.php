<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="style/assets/dist/css/bootstrap.min.css" rel="stylesheet">
	<title><?= $title ?></title>
	<?php 
		if(isset($header))
		{
			echo $header;
		}
	?>
</head>
<body>
	<?= $contenue ?>
</body>
</html>