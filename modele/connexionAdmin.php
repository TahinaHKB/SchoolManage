<?php
	include_once("fonction.php");
	$_POST['appelation'] = preg_replace("# #", "_", $_POST['appelation']);
	$req1 = $bdd->prepare("SELECT * FROM administrateur WHERE Appelation=:a AND Mdp=:mdp");
	$req1->execute(array(
		"a" => $_POST['appelation'],
		"mdp" => $_POST['mdp']
	));
	$adm = $req1->rowcount();

	$req2 = $bdd->prepare("SELECT * FROM professeur WHERE Appelation=:a AND mdp=:mdp");
	$req2->execute(array(
		"a" => $_POST['appelation'],
		"mdp" => $_POST['mdp']
	));
	$prof = $req2->rowcount();

	$req3 = $bdd->prepare("SELECT * FROM eleve WHERE Appelation=:a AND Mdp=:mdp");
	$req3->execute(array(
		"a" => $_POST['appelation'],
		"mdp" => $_POST['mdp']
	));
	$eleve = $req3->rowcount();

	if($adm==1)
	{
		$donnees = $req1->fetch();
		session_start();
		$_SESSION['Id'] = $donnees['Id'];
		$_SESSION['Type'] = "adm";
		header("Location: ../main.php");
	}
	else if($prof==1)
	{
		$donnees = $req2->fetch();
		session_start();
		$_SESSION['Id'] = $donnees['Id'];
		$_SESSION['Type'] = "prof";
		header("Location: ../main.php");
	}
	else if($eleve==1)
	{
		$donnees = $req3->fetch();
		session_start();
		$_SESSION['Id'] = $donnees['Id'];
		$_SESSION['Type'] = "eleve";
		header("Location: ../main.php");
	}
	else
	{
		session_start();
		$_SESSION['err'] = 'Appelation ou mot de passe non identifié !!!';
		header("Location: ../main.php?encode=Adm");
	}
