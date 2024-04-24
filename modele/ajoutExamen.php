<?php
include_once("fonction.php");
session_start();
$req = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");
$sco = $req->fetch();
$test = false;
$appelation = preg_replace("# #", "_", $_POST['appelation']);
$req = $bdd->prepare('INSERT INTO examen(Nom, Scolaire, DateDebut, Etat) VALUES(:a,:s,NOW(),1)');
$req->execute(array(
	"a" => $appelation,
	"s" => $sco["Id"]
));
$test = true;
if($test)
{
	$_SESSION['pResult'] = $_POST['appelation'].' a été ajouté et activé avec succès';
}
else 
{
	$_SESSION['pResult'] = 'Une erreur s\'est produite lors de l\'enregistrement';
}
header("Location: ../main.php?enc=exa");