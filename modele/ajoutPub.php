<?php
include_once("fonction.php");
session_start();
$test = false;
$appelation = preg_replace("# #", "_", $_POST['titre']);
if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error']
== 0)
{ 
// Testons si le fichier n'est pas trop gros
if ($_FILES['monfichier']['size'] <= 1000000)
{
// Testons si l'extension est autorisée
$infosfichier =
pathinfo($_FILES['monfichier']['name']);
$extension_upload = $infosfichier['extension'];
$extensions_autorisees = array('jpg', 'jpeg',
'png');
if (in_array($extension_upload,
$extensions_autorisees))
{
move_uploaded_file($_FILES['monfichier']['tmp_name'], '../image/pub/'.$appelation.'.'.$infosfichier['extension']);
$temp = $_POST;
foreach ($_POST as $key => $value) 
{
	if($_POST[$key]=='on')
	{
$req = $bdd->prepare('INSERT INTO publications(Titre, Contenu, Dates, Auteur, Audiance, Image) VALUES(:t,:c,NOW(),:a, :au, :i)');
$req->execute(array(
	"t" => $temp['titre'],
	"c" => $temp['contenue'],
	"a" => $temp['auteur'],
	"au" => $key,
	"i" => $appelation.'.'.$infosfichier['extension']
));
	}
}
$test = true;
}
}
}
else 
{
	$temp = $_POST;
foreach ($_POST as $key => $value) 
{
	if($_POST[$key]=='on')
	{
$req = $bdd->prepare('INSERT INTO publications(Titre, Contenu, Dates, Auteur, Audiance) VALUES(:t,:c,NOW(),:a, :au)');
$req->execute(array(
	"t" => $temp['titre'],
	"c" => $temp['contenue'],
	"a" => $temp['auteur'],
	"au" => $key,
));
	}
}
}
$_SESSION['pResult'] = 'La publication a été ajoutée';
header("Location: ../main.php?enc=pub");