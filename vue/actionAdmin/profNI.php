<?php
	$title = "Profil";
	ob_start();
?>
	<h1>Données introuvalble</h1>
	<a href="main.php">Retour</a>
<?php
	$contenue = ob_get_clean();
	include_once("vue/template.php");