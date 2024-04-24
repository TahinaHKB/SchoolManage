<?php
include_once("fonction.php");
session_start();
$test = false;
$req = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");
$sco = $req->fetch();
$req = $bdd->query("SELECT * FROM examen WHERE Etat=1");
$exa = $req->fetch();
$req = $bdd->prepare("SELECT * FROM eleve WHERE Classe=:c");
	$req->execute(array(
		"c" => $_POST['idC']
	));
	$eleve = $req->fetchAll();
foreach ($eleve as $key => $value) {
	$req = $bdd->prepare('INSERT INTO note(Eleve, Chiffre, Matiere, Examen, Scolaire, Prof, Classe, Coefficient) VALUES(:e, :ch, :m, :exa, :s, :p, :c, :co)');
	$req->execute(array(
		"e" => $value['Appelation'],
		"ch" => $_POST[$value['Appelation']],
		"m" => $_POST['mat'],
		"exa" => $exa['Id'],
		"s" => $sco['Id'],
		"p" => $_SESSION['me']['Appelation'],
		"c" => $_POST['c'],
		"co" => $_POST['coef']
	));
}
$test = true;
if($test)
{
	$_SESSION['pResult'] = 'Note mise à jour';
}
else 
{
	$_SESSION['pResult'] = 'Une erreur s\'est produite lors de l\'enregistrement';
}
header("Location: ../main.php?enc=not");