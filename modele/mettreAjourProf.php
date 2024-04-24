<?php
	session_start();
	include_once('fonction.php');
	if($_POST['type']=="renum")
	{
		$req = $bdd->prepare("UPDATE professeur SET Renumeration=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['renum'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Renumeration modifié";
		header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']);
	}
	else  if($_POST['type']=='matiere')
	{
		$req = $bdd->prepare("DELETE FROM connaissance WHERE professeur=:m");
		$req->execute(array(
			"m" => $_POST['Id']
		));
		$requete = $bdd->query("SELECT * FROM matiere ");
		$classe = $requete->fetchAll();
		$req2 = $bdd->prepare('SELECT * FROM professeur WHERE Appelation=:n');
		$req2->execute(array(
			"n" => $_POST['perso']
		));
		$mat = $req2->fetch();
		foreach ($classe as $key => $value) 
		{
			if(isset($_POST[$value['Nom']]))
			{
				$req = $bdd->prepare('INSERT INTO connaissance(Professeur, Matiere) VALUES(:c, :m)');
				$req->execute(array(
				"c" => $mat['Id'],
				"m" => $value['Id']
				));
			}
			else 
			{
				$req = $bdd->prepare("DELETE FROM enseigne WHERE Professeur=:m AND Matiere=:mat");
				$req->execute(array(
					"m" => $_POST['Id'],
					"mat" => $value['Id']
				));
			}
		}
		$_SESSION['pResult'] = "Matière correspondant modifié, reinitialisation des classes";
		header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']);
	}
	else  if($_POST['type']=='classe')
	{
		$req = $bdd->prepare("DELETE FROM enseigne WHERE professeur=:m AND matiere=:mat");
		$req->execute(array(
			"m" => $_POST['Id'],
			"mat" => $_POST['Matiere']
		));
		$requete = $bdd->query("SELECT * FROM classe");
		$classe = $requete->fetchAll();
		$req2 = $bdd->prepare('SELECT * FROM professeur WHERE Appelation=:n');
		$req2->execute(array(
			"n" => $_POST['perso']
		));
		$mat = $req2->fetch();
		foreach ($classe as $key => $value) 
		{
			if(isset($_POST[$value['Nom'].$value['Identifiant']]))
			{
				$req = $bdd->prepare('INSERT INTO enseigne(Classe, Professeur, Matiere) VALUES(:c, :p, :m)');
				$req->execute(array(
				"c" => $value['Id'],
				"p" => $_POST['Id'], 
				'm' => $_POST['Matiere']
				));
			}
		}
		$_SESSION['pResult'] = "Classe correspondant modifié";
		header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']);
	}
	else if($_POST['type']=="num")
	{
		$req = $bdd->prepare("UPDATE professeur SET Numero=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['renum'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Numero modifié";
		header("Location: ../main.php?enc=profil&t=prof");
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
					move_uploaded_file($_FILES['monfichier']['tmp_name'], '../image/prof/'.basename($_FILES['monfichier']['name']));
					$req = $bdd->prepare("UPDATE professeur SET Photo=:r WHERE Id=:i ");
					$req->execute(array(
						"r" => basename($_FILES['monfichier']['name']),
						"i" => $_POST['Id']
					));
					$_SESSION['pResult'] = "photo modifié";
					header("Location: ../main.php?enc=profil&t=prof");
				}
			}
		}
	}
	else if($_POST['type']=='nom')
	{
		$req = $bdd->prepare("UPDATE professeur SET Appelation=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => preg_replace("# #", "_", $_POST['renum']),
			"i" => $_POST['Id']
		));
		$req = $bdd->prepare("UPDATE note SET Prof=:r WHERE Prof=:i ");
		$req->execute(array(
			"r" => preg_replace("# #", "_", $_POST['renum']),
			"i" => $_POST['perso']
		));
		$_SESSION['pResult'] = "Appelation modifié";
		header("Location: ../main.php?enc=profil&t=prof");
	}
	else if($_POST['type']=="mdp") 
	{
		$rech = $bdd->prepare("SELECT mdp FROM professeur WHERE Id=:i");
		$rech->execute(array(
			"i" => $_POST['Id']
		));
		$data = $rech->fetch();
		if($data['mdp']==$_POST['mdp'])
		{
			$req = $bdd->prepare("UPDATE professeur SET mdp=:r WHERE Id=:i ");
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
		header("Location: ../main.php?enc=profil&t=prof");
	}
	else if($_POST['type']=='mail')
	{
		$req = $bdd->prepare("UPDATE professeur SET Email=:r WHERE Id=:i ");
		$req->execute(array(
			"r" => $_POST['renum'],
			"i" => $_POST['Id']
		));
		$_SESSION['pResult'] = "Email modifié";
		header("Location: ../main.php?enc=profil&t=prof");
	}