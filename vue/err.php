<?php
	$title = "Erreur";
	ob_start();
?>
	<h1>Veuillez ne pas toucher aux paramètres svp</h1>
	<a href="main.php">Retour</a>
<?php
	$contenue = ob_get_clean();
	include_once("template.php");