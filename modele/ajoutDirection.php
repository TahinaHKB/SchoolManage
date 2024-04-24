<?php
include_once("fonction.php");
session_start();
$test = false;
$appelation = preg_replace("# #", "_", $_POST['appelation']);
$req = $bdd->prepare('INSERT INTO administrateur(Appelation, Renumeration, Adresse, Numero, DateDebut, Mdp, Email, Statue) VALUES(:a,:r,:ad,:num,NOW(),:m, :e, :s)');
$req->execute(array(
	"a" => $appelation,
	"r" => $_POST['renum'], 
	"ad" => $_POST['adresse'], 
	"num" => $_POST['num'],
	"m" => $_POST['mdp'],
	"e" => $_POST['email'],
	"s" => "Aide"
));
$test = true;
if($test)
{
	$_SESSION['pResult'] = $_POST['appelation'].' a été ajouté avec succès';
}
else 
{
	$_SESSION['pResult'] = 'Une erreur s\'est produite lors de l\'enregistrement';
}
header("Location: ../main.php?enc=drt");