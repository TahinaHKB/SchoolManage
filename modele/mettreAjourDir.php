<?php
	session_start();
	include_once('fonction.php');
	if($_POST['type']=="renum")
	{
		$req = $bdd->prepare("UPDATE administrateur SET Renumeration=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['renum'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Renumeration modifié";
		header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']."&t=d");
	}
	else if($_POST['type']=="num")
	{
		$req = $bdd->prepare("UPDATE administrateur SET Numero=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['renum'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Numero modifié";
		header("Location: ../main.php?enc=profil&t=adm");
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
					move_uploaded_file($_FILES['monfichier']['tmp_name'], '../image/adm/'.basename($_FILES['monfichier']['name']));
					$req = $bdd->prepare("UPDATE administrateur SET Photo=:r WHERE Id=:i ");
					$req->execute(array(
						"r" => basename($_FILES['monfichier']['name']),
						"i" => $_POST['Id']
					));
					$_SESSION['pResult'] = "photo modifié";
					header("Location: ../main.php?enc=profil&t=adm");
				}
			}
		}
	}
	else if($_POST['type']=='nom')
	{
		$req = $bdd->prepare("UPDATE administrateur SET Appelation=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => preg_replace("# #", "_", $_POST['renum']),
			"i" => $_POST['Id']
		));
		$req = $bdd->prepare("UPDATE publications SET Auteur=:r WHERE Auteur=:i ");
		$req->execute(array(
			"r" => preg_replace("# #", "_", $_POST['renum']),
			"i" => $_POST['perso']
		));
		$_SESSION['pResult'] = "Appelation modifié";
		header("Location: ../main.php?enc=profil&t=adm");
	}
	else if($_POST['type']=="mdp") 
	{
		$rech = $bdd->prepare("SELECT Mdp FROM administrateur WHERE Id=:i");
		$rech->execute(array(
			"i" => $_POST['Id']
		));
		$data = $rech->fetch();
		if($data['Mdp']==$_POST['mdp'])
		{
			$req = $bdd->prepare("UPDATE administrateur SET Mdp=:r WHERE Id=:i ");
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
		header("Location: ../main.php?enc=profil&t=adm");
	}
	else if($_POST['type']=='mail')
	{
		$req = $bdd->prepare("UPDATE administrateur SET Email=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['renum'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Email modifié";
		header("Location: ../main.php?enc=profil&t=adm");
	}
	header("Location: ../main.php?enc=profil&t=adm");