<?php
include_once("fonction.php");
session_start();

$rech = $bdd->query("SELECT Nom FROM classe");
if(isset($_POST['appelation'][1]))
{
	$d = 1;
}
else 
{
	$d = 'A';
}
while ($don = $rech->fetch()) {
	if($don['Nom']==$_POST['appelation'])
	{
		$d++;
	}
}

for($i=0;$i<$_POST['nb'];$i++)
{
	$test = false;
	$req = $bdd->prepare('INSERT INTO classe(Nom, Titulaire, PlaceMax, Eleve, Identifiant) VALUES(:n , 0, :p, 0, :i)');
	$req->execute(array(
		"n" => $_POST['appelation'],
		"p" => $_POST['place'],
		"i" => $d
	));
	$test = true;
	$d++;
}
if($test)
{
	$_SESSION['pResult'] = 'Ajout des classes reussies';
}
else 
{
	$_SESSION['pResult'] = 'Une erreur s\'est produite lors de l\'enregistrement';
}
header("Location: ../main.php?enc=cla");