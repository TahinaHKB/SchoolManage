<?php
	function giveDataProf($Id, $nom)
	{ 
		global $bdd;
		$req = $bdd->prepare("SELECT * FROM professeur WHERE Id=:i");
		$req->execute(array(
			"i" => $Id
		));
		$nb = $req->rowCount();
		$donnees['valider'] = false;
		if($nb==1)
		{
			$donnees = $req->fetch();
			if($donnees['Appelation']==$nom)
			{
				$donnees['valider'] = true;
			}
		}
		return $donnees;
	}
	function giveDataDir($Id, $nom)
	{ 
		global $bdd;
		$req = $bdd->prepare("SELECT * FROM administrateur WHERE Id=:i");
		$req->execute(array(
			"i" => $Id
		));
		$nb = $req->rowCount();
		$donnees['valider'] = false;
		if($nb==1)
		{
			$donnees = $req->fetch();
			if($donnees['Appelation']==$nom)
			{
				$donnees['valider'] = true;
			}
		}
		return $donnees;
	}
	function giveDataClas($Id, $nom)
	{ 
		global $bdd;
		$req = $bdd->prepare("SELECT * FROM classe WHERE Id=:i");
		$req->execute(array(
			"i" => $Id
		));
		$nb = $req->rowCount();
		$donnees['valider'] = false;
		if($nb==1)
		{
			$donnees = $req->fetch();
			if($donnees['Nom']==$nom)
			{
				$donnees['valider'] = true;
			}
		}
		return $donnees;
	}
	function giveDataMat($Id, $nom)
	{ 
		global $bdd;
		$req = $bdd->prepare("SELECT * FROM matiere WHERE Id=:i");
		$req->execute(array(
			"i" => $Id
		));
		$nb = $req->rowCount();
		$donnees['valider'] = false;
		if($nb==1)
		{
			$donnees = $req->fetch();
			if($donnees['Nom']==$nom)
			{
				$donnees['valider'] = true;
			}
		}
		return $donnees;
	}
	function giveDataElv($Id, $nom)
	{ 
		global $bdd;
		$req = $bdd->prepare("SELECT * FROM eleve WHERE Id=:i");
		$req->execute(array(
			"i" => $Id
		));
		$nb = $req->rowCount();
		$donnees['valider'] = false;
		if($nb==1)
		{
			$donnees = $req->fetch();
			if($donnees['Appelation']==$nom)
			{
				$donnees['valider'] = true;
			}
		}
		return $donnees;
	}