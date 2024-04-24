<?php
include_once("fonction.php");
session_start();
$test = false;
$requete = $bdd->query("SELECT * FROM classe ");
$classe = $requete->fetchAll();
$req = $bdd->prepare('INSERT INTO matiere(Nom) VALUES(:n)');
$req->execute(array(
	"n" => $_POST['nom']
));
$req2 = $bdd->prepare('SELECT * FROM matiere WHERE Nom=:n');
$req2->execute(array(
	"n" => $_POST['nom']
));
$mat = $req2->fetch();
foreach ($classe as $key => $value) {
	if(isset($_POST[$value['Nom'].$value['Identifiant']]))
	{
		$req = $bdd->prepare('INSERT INTO correspondance(Classe, Matiere, Coefficient) VALUES(:c, :m, 1)');
		$req->execute(array(
			"c" => $value['Id'],
			"m" => $mat['Id']
		));
	}
}
$test = true;
if($test)
{
	$_SESSION['pResult'] = $_POST['nom'].' a été ajouté avec succès';
}
else 
{
	$_SESSION['pResult'] = 'Une erreur s\'est produite lors de l\'enregistrement';
}
header("Location: ../main.php?enc=mat");