<?php
include_once("fonction.php");
session_start();
$test = false;
if($_POST['type']=='ecollage')
{
$req = $bdd->prepare('INSERT INTO payement(Numero, Reference, Eleve, Somme, Nombre, Type) VALUES(:n, :r, :e, :s, :nb, :t)');
$req->execute(array(
	"n" => $_POST['num'],
	"r" => $_POST['ref'],
	"e" => $_POST['nom'],
	"s" => $_POST['som'],
	"nb" => $_POST['nb'], 
	"t" => $_POST['type']
));
$test = true;
if($test)
{
	$_SESSION['pResult'] = "L envoie a été effectué et va etre verifier avant d etre confirmer";
}
else 
{
	$_SESSION['pResult'] = 'Une erreur s\'est produite lors de l\'enregistrement';
}
header("Location: ../main.php?enc=ecoEl");
}
else 
{
$req = $bdd->prepare('INSERT INTO payement(Numero, Reference, Eleve, Somme, Type) VALUES(:n, :r, :e, :s, :t)');
$req->execute(array(
	"n" => $_POST['num'],
	"r" => $_POST['ref'],
	"e" => $_POST['nom'],
	"s" => $_POST['som'],
	"t" => $_POST['type']
));
$test = true;
if($test)
{
	$_SESSION['pResult'] = "L envoie a été effectué et va etre verifier avant d etre confirmer";
}
else 
{
	$_SESSION['pResult'] = 'Une erreur s\'est produite lors de l\'enregistrement';
}
header("Location: ../main.php");	
}

