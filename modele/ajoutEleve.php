<?php
include_once("fonction.php");
session_start();
$appelation = preg_replace("# #", "_", $_POST['appelation']);
$test = false;
$rech = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");
if($rech->rowCount()==0)
{
	$_SESSION['pResult'] = 'Aucune année scolaire en cours';
	header("Location: ../main.php?enc=sco");
}
$scolaire = $rech->fetch();
$rech2 = $bdd->prepare("SELECT * FROM classe WHERE Nom=:n AND Eleve<PlaceMax ORDER BY Identifiant");
$rech2->execute(array(
	"n" => $_POST['classe']
));
$classe = $rech2->fetch();
$action = $bdd->prepare("UPDATE classe SET Eleve=Eleve+1 WHERE Id=:i");
$action->execute(array(
	"i" => $classe['Id']
));
$req = $bdd->prepare('INSERT INTO eleve(Appelation, Adresse, Numero, Dates, Mdp, Mail, Classe, Scolaire) VALUES(:a,:ad,:num,NOW(),:m, :e, :c, :sc)');
$req->execute(array(
	"a" => $appelation,
	"ad" => $_POST['adresse'], 
	"num" => $_POST['num'],
	"m" => $_POST['mdp'],
	"e" => $_POST['email'],
	"c" => $classe['Id'],
	"sc" => $scolaire['Id']
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
header("Location: ../main.php?enc=elv");