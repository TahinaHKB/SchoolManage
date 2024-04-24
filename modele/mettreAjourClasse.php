<?php
	session_start();
	include_once('fonction.php');
	if($_POST['type']=="place")
	{
		$req = $bdd->prepare("UPDATE classe SET PlaceMax=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['capacite'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Capacite modifié";
		header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']."&t=cl");
	}
	else if($_POST['type']=='Titulaire')
	{
		$req = $bdd->prepare("UPDATE classe SET Titulaire=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['titulaire'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Titulaire modifié";
		header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']."&t=cl");
	}