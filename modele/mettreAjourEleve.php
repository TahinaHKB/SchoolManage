<?php
	session_start();
	include_once('fonction.php');
if($_POST['type']=='reinscrire')
{
	$req = $bdd->prepare("UPDATE eleve SET Classe=:r WHERE Id=:i ");
	$req->execute(array(
		"r" => $_POST['classe'],
		"i" => $_POST['Id']
	));
	$action = $bdd->prepare("UPDATE classe SET Eleve=Eleve-1 WHERE Id=:i");
$action->execute(array(
	"i" => $_SESSION['IdC']
));
	$action = $bdd->prepare("UPDATE classe SET Eleve=Eleve+1 WHERE Id=:i");
$action->execute(array(
	"i" => $_POST['classe']
));
	$action = $bdd->prepare("DELETE FROM payement WHERE Eleve=:i AND Type<>:t");
$action->execute(array(
	"i" => $_POST['Id'],
	"t" => "ecollage"
));
	$_SESSION['IdC'] = $_POST['classe'];
	$_SESSION['pResult'] = "Classe modifié";
	header("Location: ../main.php?enc=elv");
}
else if($_POST['type']=="num")
	{
		$req = $bdd->prepare("UPDATE eleve SET Numero=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['renum'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Numero modifié";
		header("Location: ../main.php?enc=profil&t=elv");
	}
	else if($_POST['type']=='photo')
	{
		if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error']== 0)
		{
			// Testons si le fichier n'est pas trop gros
			if ($_FILES['monfichier']['size'] <= 1000000)
			{
				// Testons si l'extension est autorisée
				$infosfichier = pathinfo($_FILES['monfichier']['name']);
				$extension_upload = $infosfichier['extension'];
				$extensions_autorisees = array('jpg', 'jpeg','png');
				if (in_array($extension_upload,$extensions_autorisees))
				{
					move_uploaded_file($_FILES['monfichier']['tmp_name'], '../image/eleve/'.basename($_FILES['monfichier']['name']));
					$req = $bdd->prepare("UPDATE eleve SET Photo=:r WHERE Id=:i ");
					$req->execute(array(
						"r" => basename($_FILES['monfichier']['name']),
						"i" => $_POST['Id']
					));
					$_SESSION['pResult'] = "photo modifié";
					header("Location: ../main.php?enc=profil&t=elv");
				}
			}
		}
	}
	else if($_POST['type']=='nom')
	{
		$req = $bdd->prepare("UPDATE eleve SET Appelation=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => preg_replace("# #", "_", $_POST['renum']),
			"i" => $_POST['Id']
		));
		$req = $bdd->prepare("UPDATE note SET Eleve=:r WHERE Eleve=:i ");
		$req->execute(array(
			"r" => preg_replace("# #", "_", $_POST['renum']),
			"i" => $_POST['perso']
		));
		$_SESSION['pResult'] = "Appelation modifié";
		header("Location: ../main.php?enc=profil&t=elv");
	}
	else if($_POST['type']=="mdp") 
	{
		$rech = $bdd->prepare("SELECT Mdp FROM eleve WHERE Id=:i");
		$rech->execute(array(
			"i" => $_POST['Id']
		));
		$data = $rech->fetch();
		if($data['Mdp']==$_POST['mdp'])
		{
			$req = $bdd->prepare("UPDATE eleve SET Mdp=:r WHERE Id=:i ");
			$req->execute(array(
				"r" => $_POST['mdpNew'],
				"i" => $_POST['Id']
			));
			$_SESSION['pResult'] = "Mot de passe changé";
		}
		else 
		{
			$_SESSION['pResult'] = 'Mot de passe non valide';
		}
		header("Location: ../main.php?enc=profil&t=elv");
	}
	else if($_POST['type']=='mail')
	{
		$req = $bdd->prepare("UPDATE eleve SET Mail=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['renum'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Email modifié";
		header("Location: ../main.php?enc=profil&t=elv");
	}
else
{
$rech = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");

if($rech->rowCount()==0)
{
	$_SESSION['pResult'] = 'Aucune année scolaire en cours';
	header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']."&t=elv");
}
	$req = $bdd->prepare("UPDATE eleve SET Classe=:r WHERE Id=:i ");
	$req->execute(array(
		"r" => $_POST['classe'],
		"i" => $_POST['Id']
	));
	$action = $bdd->prepare("UPDATE classe SET Eleve=Eleve-1 WHERE Id=:i");
$action->execute(array(
	"i" => $_SESSION['IdC']
));
	$action = $bdd->prepare("UPDATE classe SET Eleve=Eleve+1 WHERE Id=:i");
$action->execute(array(
	"i" => $_POST['classe']
));
	$_SESSION['IdC'] = $_POST['classe'];
	$_SESSION['pResult'] = "Classe modifié";
	header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']."&t=elv");
}