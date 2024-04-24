<?php
	function giveData($Id, $type)
	{ 
		global $bdd;
		if($type=="adm")
		{
			$req = $bdd->prepare("SELECT * FROM administrateur WHERE Id=:i");
			$req->execute(array(
				"i" => $Id
			));
			$donnees = $req->fetch();
		}
		else if($type=="prof")
		{
			$req = $bdd->prepare("SELECT * FROM professeur WHERE Id=:i");
			$req->execute(array(
				"i" => $Id
			));
			$donnees = $req->fetch();
		}
		else 
		{
			$req = $bdd->prepare("SELECT * FROM eleve WHERE Id=:i");
			$req->execute(array(
				"i" => $Id
			));
			$donnees = $req->fetch();
		}
		$donnees['compte'] = $type;
		return $donnees;
	}