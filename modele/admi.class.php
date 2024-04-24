<?php 
Class Admin
{
	private $data;
	public function __construct($d)
	{
		$this->data = $d;
	}
	public function getAppelation()
	{
		return $this->data['Appelation'];
	}
	public function getMembre()
	{
		return $this->data;
	}
	public function getCompte()
	{
		return $this->data['compte'];
	}
	public function testerStatue()
	{
		if(isset($this->data['Statue']))
		{
			return $this->data['Statue']=="General";
		}
		else 
		{
			return false;
		}
	}
	public function donnerProf()
	{
		global $bdd;
		$req = $bdd->query("SELECT * FROM professeur ORDER BY Appelation");
		$donnees = $req->fetchAll();
		return $donnees;
	}
	public function supProf($id)
	{
		global $bdd;
		$req = $bdd->prepare("DELETE FROM professeur WHERE Id=:i ");
		$req->execute(array(
			"i" => $id
		));
		$req = $bdd->prepare("DELETE FROM connaissance WHERE Professeur=:i ");
		$req->execute(array(
			"i" => $id
		));
		$req = $bdd->prepare("DELETE FROM enseigne WHERE Professeur=:i ");
		$req->execute(array(
			"i" => $id
		));
		$req = $bdd->prepare("UPDATE classe SET Titulaire=0 WHERE Titulaire=:i ");
		$req->execute(array(
			"i" => $id
		));
	}
	public function donnerDirection()
	{
		global $bdd;
		$req = $bdd->query("SELECT * FROM administrateur WHERE Id!=1 ORDER BY Appelation");
		$donnees = $req->fetchAll();
		return $donnees;
	}
	public function supDir($id)
	{
		global $bdd;
		$req = $bdd->prepare("DELETE FROM administrateur WHERE Id=:i ");
		$req->execute(array(
			"i" => $id
		));
	}
	public function donnerClasse()
	{
		global $bdd;
		$req = $bdd->query("SELECT * FROM classe ORDER BY Nom");
		$donnees = $req->fetchAll();
		return $donnees;
	}
	public function supClasse($id)
	{
		global $bdd;
		$req = $bdd->prepare("DELETE FROM classe WHERE Id=:i ");
		$req->execute(array(
			"i" => $id
		));
		$req = $bdd->prepare("DELETE FROM correspondance WHERE Classe=:i ");
		$req->execute(array(
			"i" => $id
		));
		$req = $bdd->prepare("DELETE FROM enseigne WHERE Classe=:i ");
		$req->execute(array(
			"i" => $id
		));
	}
	public function donnerMatiere()
	{
		global $bdd;
		$req = $bdd->query("SELECT * FROM matiere");
		$donnees = $req->fetchAll();
		return $donnees;
	}
	public function supMatiere($id)
	{
		global $bdd;
		$req = $bdd->prepare("DELETE FROM matiere WHERE Id=:i ");
		$req->execute(array(
			"i" => $id
		));
		$req = $bdd->prepare("DELETE FROM correspondance WHERE Matiere=:i ");
		$req->execute(array(
			"i" => $id
		));
		$req = $bdd->prepare("DELETE FROM connaissance WHERE Matiere=:i ");
		$req->execute(array(
			"i" => $id
		));
		$req = $bdd->prepare("DELETE FROM enseigne WHERE Matiere=:i ");
		$req->execute(array(
			"i" => $id
		));
	}
	public function donnerScolaire()
	{
		global $bdd;
		$req = $bdd->query("SELECT * FROM annee_scolaire");
		$donnees = $req->fetchAll();
		return $donnees;
	}
	public function donnerExamen()
	{
		global $bdd;
		$req = $bdd->query("SELECT * FROM examen");
		$donnees = $req->fetchAll();
		return $donnees;
	}
	public function supEleve($id)
	{
		global $bdd;
		$action = $bdd->prepare("UPDATE classe SET Eleve=Eleve-1 WHERE Id=:i");
$action->execute(array(
	"i" => $_SESSION['IdC']
));
		$req = $bdd->prepare("DELETE FROM eleve WHERE Id=:i ");
		$req->execute(array(
			"i" => $id
		));
	}
	public function verifieSco($Id)
	{ 
		global $bdd;
		$req = $bdd->prepare("SELECT * FROM annee_scolaire WHERE Id=:i");
		$req->execute(array(
			"i" => $Id
		));
		$nb = $req->rowCount();
		return $nb==1;
	}
	public function verifieExa($Id)
	{ 
		global $bdd;
		$req = $bdd->prepare("SELECT * FROM examen WHERE Id=:i");
		$req->execute(array(
			"i" => $Id
		));
		$nb = $req->rowCount();
		return $nb==1;
	}
	public function verifieClaN($Id)
	{ 
		global $bdd;
		$req = $bdd->prepare("SELECT * FROM note WHERE Classe=:i");
		$req->execute(array(
			"i" => $Id
		));
		$nb = $req->rowCount();
		return $nb>0;
	}
	public function verifieEl($Id)
	{ 
		global $bdd;
		$req = $bdd->prepare("SELECT * FROM note WHERE Eleve=:i");
		$req->execute(array(
			"i" => $Id
		));
		$nb = $req->rowCount();
		return $nb>0;
	}
}