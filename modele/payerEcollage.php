<?php
	session_start();
	include_once("fonction.php");
	foreach ($_POST as $key => $value) {
		if($value=="on")
		{
			$action = $bdd->prepare("INSERT INTO ecollage(Eleve, Mois, scolaire) VALUES(:e, :m, :s)");
			$action->execute(array(
				"e" => $_POST['perso'],
				"m" => $key,
				"s" => $_POST['scolaire']
			)); 
		}
	}
	$rech = $bdd->prepare("SELECT * FROM eleve WHERE Appelation=:i");
			$rech->execute(array(
				"i" => $_POST['perso']
			));
			$perso = $rech->fetch();
	$action = $bdd->prepare("DELETE FROM payement WHERE Eleve=:i AND Type=:t");
$action->execute(array(
	"i" => $perso['Id'],
	"t" =>"ecollage"
));
	header("Location: ../main.php?enc=eco&id=".$_POST['Id']."&perso=".$_POST['perso']);
