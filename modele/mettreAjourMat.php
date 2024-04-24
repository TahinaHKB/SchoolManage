<?php
	session_start();
	include_once('fonction.php');
	if($_POST['type']=="coefficient")
	{
		$req = $bdd->prepare("SELECT c.Classe cla, c.Coefficient coef, cl.Nom nomClasse, cl.Identifiant idClasse FROM correspondance c INNER JOIN classe cl ON cl.Id=c.Classe WHERE c.Matiere=:m");
		$req->execute(array(
			"m" => $_POST['Id']
		));
		$classe = $req->fetchAll();

		foreach ($classe as $key => $value) 
		{
			$req = $bdd->prepare("UPDATE correspondance SET Coefficient=:r WHERE Classe=:i AND Matiere=:m");
			$req->execute(array(
				"r" => $_POST[$value['nomClasse'].$value['idClasse']],
				"i" => $value["cla"],
				"m" => $_POST['Id']
			));
		}
		
		$_SESSION['pResult'] = "Coefficient modifié";
		header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']."&t=mat");
	}
	else 
	{
		$req = $bdd->prepare("DELETE FROM correspondance WHERE Matiere=:m");
		$req->execute(array(
			"m" => $_POST['Id']
		));
		$requete = $bdd->query("SELECT * FROM classe ");
		$classe = $requete->fetchAll();
		$req2 = $bdd->prepare('SELECT * FROM matiere WHERE Nom=:n');
		$req2->execute(array(
			"n" => $_POST['perso']
		));
		$mat = $req2->fetch();
		foreach ($classe as $key => $value) 
		{
			if(isset($_POST[$value['Nom'].$value['Identifiant']]))
			{
				$req = $bdd->prepare('INSERT INTO correspondance(Classe, Matiere, Coefficient) VALUES(:c, :m, 1)');
				$req->execute(array(
				"c" => $value['Id'],
				"m" => $mat['Id']
				));
			}
		}
		$_SESSION['pResult'] = "Matière correspondant modifié";
		header("Location: ../main.php?id=".$_POST['Id']."&perso=".$_POST['perso']."&t=mat");
	}