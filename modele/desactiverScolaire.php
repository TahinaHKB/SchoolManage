<?php
	session_start();
	include_once('fonction.php');
		$req = $bdd->prepare("UPDATE annee_scolaire SET Etat=0, DateFin=NOW() WHERE Id=:i ");
		$req->execute(array(
			"i" => $_GET['id']
		));
		$_SESSION['pResult'] = "Annee scolaire fini";
		$req = $bdd->exec("UPDATE eleve SET Classe=36");
		$req = $bdd->exec("UPDATE classe SET Eleve=0");
		$rech = $bdd->query("SELECT COUNT(*) as nb FROM eleve");
		$nb = $rech->fetch();
		$req = $bdd->prepare("UPDATE classe SET Eleve=:e WHERE Id=36");
		$req->execute(array(
			"e" => $nb['nb']
		));
		header("Location: ../main.php?enc=sco");