<?php
include_once("fonction.php");
session_start();
$test = false;
$appelation = preg_replace("# #", "_", $_POST['appelation']);
// if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error']
// == 0)
// {
// // Testons si le fichier n'est pas trop gros
// if ($_FILES['monfichier']['size'] <= 1000000)
// {
// // Testons si l'extension est autorisée
// $infosfichier =
// pathinfo($_FILES['monfichier']['name']);
// $extension_upload = $infosfichier['extension'];
// $extensions_autorisees = array('jpg', 'jpeg',
// 'png');
// if (in_array($extension_upload,
// $extensions_autorisees))
// {
// move_uploaded_file($_FILES['monfichier']['tmp_name'], '../image/prof/'.$appelation.'.'.$infosfichier['extension']);
// $req = $bdd->prepare('INSERT INTO professeur(Appelation, Renumeration, Adresse, Numero, Dates, mdp, photo) VALUES(:a,:r,:ad,:num,NOW(),:m,:p)');
// $req->execute(array(
// 	"a" => $appelation,
// 	"r" => $_POST['renum'], 
// 	"ad" => $_POST['adresse'], 
// 	"num" => $_POST['num'],
// 	"m" => $_POST['mdp'],
// 	"p" => $appelation.'.'.$infosfichier['extension']
// ));
// $test = true;
// }
// }
// }
$req = $bdd->prepare('INSERT INTO professeur(Appelation, Renumeration, Adresse, Numero, Dates, mdp, Email) VALUES(:a,:r,:ad,:num,NOW(),:m, :e)');
$req->execute(array(
	"a" => $appelation,
	"r" => $_POST['renum'], 
	"ad" => $_POST['adresse'], 
	"num" => $_POST['num'],
	"m" => $_POST['mdp'],
	"e" => $_POST['email']
));
$req2 = $bdd->prepare('SELECT * FROM professeur WHERE Appelation=:n');
$req2->execute(array(
	"n" => $appelation
));
$prof = $req2->fetch();
$req = $bdd->query("SELECT * FROM matiere");
$mat = $req->fetchAll();
foreach ($mat as $key => $value) {
	if(isset($_POST[$value['Nom']]))
	{
		$req = $bdd->prepare('INSERT INTO connaissance(Professeur, Matiere) VALUES(:c, :m)');
		$req->execute(array(
			"c" => $prof['Id'],
			"m" => $value['Id']
		));
	}
}
$test = true;
if($test)
{
	$_SESSION['pResult'] = $_POST['appelation'].' a été ajouté avec succès';
}
else 
{
	$_SESSION['pResult'] = 'Une erreur s\'est produite lors de l\'enregistrement';
}
header("Location: ../main.php?enc=prf");