<?php
	session_start();
	include_once('fonction.php');
		$req = $bdd->prepare("UPDATE examen SET Etat=0, DateFin=NOW() WHERE Id=:i ");
		$req->execute(array(
			"i" => $_GET['id']
		));
		$_SESSION['pResult'] = "Resultat publié";
		header("Location: ../main.php?enc=exa");