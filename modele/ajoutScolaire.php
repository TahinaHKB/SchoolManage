<?php
include_once("fonction.php");
session_start();
$test = false;
$appelation = preg_replace("# #", "_", $_POST['appelation']);
$req = $bdd->prepare('INSERT INTO annee_scolaire(Nom, DateDebut, Etat) VALUES(:a,NOW(),1)');
$req->execute(array(
	"a" => $_POST['appelation']
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
header("Location: ../main.php?enc=sco");