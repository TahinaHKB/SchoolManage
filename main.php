<?php 
	include_once("modele/fonction.php");
	include_once("modele/infoAdm.php");
	include_once("modele/admi.class.php");
	include_once("modele/infoProf.php");
	session_start();
	if(isset($_GET['encode']))
	{
		if($_GET['encode']=='Adm')
		{
			include_once("vue/connectAdm.php");
		}
		else if($_GET['encode']=='dex')
		{
			session_destroy();
			session_start();
			include_once("vue/acceuil.php");
		}
		else if($_GET['encode']=='Pos')
		{
			include_once("vue/postuler.php");
		}
		else 
		{
			include_once("vue/err.php");
		}	

	}
	else if(isset($_SESSION['Id']))
	{
		$info = giveData($_SESSION['Id'], $_SESSION['Type']);
		$membre = new Admin($info);
		$_SESSION['membre'] = $membre;
		if(isset($_GET['enc']))
		{
			if($_GET['enc']=='prf' && $membre->testerStatue())
			{
				$donnees = $membre->donnerProf();
				include_once("vue/actionAdmin/gestionProf.php");
			}
			else if($_GET['enc']=='sup')
			{
				if(isset($_GET['t']))
				{
					if($_GET['t']=='cl')
					{
						$membre->supClasse($_GET['id']);
						$_SESSION['pResult'] = $_GET['perso'].' a été supprimé avec succès ! ';
						$donnees = $membre->donnerClasse();
						include_once("vue/actionAdmin/gestionClasse.php");
					}
					else if($_GET['t']=='mat')
					{
						$membre->supMatiere($_GET['id']);
						$_SESSION['pResult'] = $_GET['perso'].' a été supprimé avec succès ! ';
						$donnees = $membre->donnerMatiere();
						$classe = $membre->donnerClasse();
						include_once("vue/actionAdmin/gestionMatiere.php");
					}
					else if($_GET['t']=='elv')
					{
						$membre->supEleve($_GET['id']);
						header("Location: main.php?enc=clEl&id=".$_SESSION['IdC']."&perso=".$_SESSION['NomC']);
					}
					else
					{
						$membre->supDir($_GET['id']);
						$_SESSION['pResult'] = $_GET['perso'].' a été supprimé avec succès ! ';
						$donnees = $membre->donnerDirection();
						include_once("vue/actionAdmin/gestionDirection.php");
					}
				}
				else 
				{
					$membre->supProf($_GET['id']);
					$_SESSION['pResult'] = $_GET['perso'].' a été supprimé avec succès ! ';
					$donnees = $membre->donnerProf();
					include_once("vue/actionAdmin/gestionProf.php");
				}
				
			}
			else if($_GET['enc']=='drt' && $membre->testerStatue())
			{
				$donnees = $membre->donnerDirection();
				include_once("vue/actionAdmin/gestionDirection.php");
			}
			else if($_GET['enc']=='cla' && $membre->testerStatue())
			{
				$donnees = $membre->donnerClasse();
				include_once("vue/actionAdmin/gestionClasse.php");
			}
			else if($_GET['enc']=='mat' && $membre->testerStatue())
			{
				$donnees = $membre->donnerMatiere();
				$classe = $membre->donnerClasse();
				include_once("vue/actionAdmin/gestionMatiere.php");
			}
			else if($_GET['enc']=='sco' && $membre->testerStatue())
			{
				$donnees = $membre->donnerScolaire();
				include_once("vue/actionAdmin/anneeScolaire.php");
			}
			else if($_GET['enc']=='exa' && $membre->testerStatue())
			{
				$donnees = $membre->donnerExamen();
				include_once("vue/actionAdmin/examen.php");
			}
			else if($_GET['enc']=='elv' && $membre->getCompte()=='adm')
			{
				include_once("vue/actionDir/gestionEleve.php");
			}
			else if($_GET['enc']=='clEl' && $membre->getCompte()=='adm')
			{
				$prof = giveDataClas($_GET['id'], $_GET['perso']);
				if(isset($prof['valider']) && $prof['valider'])
				{
					$rech = $bdd->prepare("SELECT * FROM eleve WHERE classe=:c ORDER BY Appelation");
					$rech->execute(array(
						"c" => $_GET['id']
					));
					$eleve = $rech->fetchAll();
					$rech2 = $bdd->prepare("SELECT * FROM classe WHERE Id=:i");
					$rech2->execute(array(
						"i" => $_GET['id']
					));
					$cl = $rech2->fetch();
					include_once("vue/actionDir/afficheEleve.php");
				}
				else 
				{
					include_once("vue/actionAdmin/profNI.php");
				}
			}
			else if($_GET['enc']=='eco' && $membre->getCompte()=='adm')
			{
				$prof = giveDataElv($_GET['id'], $_GET['perso']);
				if(isset($prof['valider']) && $prof['valider'])
				{
					include("vue/actionDir/ecollage.php");
				}
				else 
				{
					include_once("vue/actionAdmin/profNI.php");
				}
			}
			else if($_GET['enc']=='not' && $membre->getCompte()=='prof')
			{
				include_once("vue/actionProf/donnerNote.php");
			}
			else if($_GET['enc']=='resu')
			{
				if(isset($_GET['sco']) && $membre->verifieSco($_GET['sco']))
				{
					if(isset($_GET['exa']) && $membre->verifieExa($_GET['exa']))
					{
						if(isset($_GET['cla']) && $membre->verifieClaN($_GET['cla']))
						{
							if(isset($_GET['el']) && $membre->verifieEl($_GET['el']))
							{
								include_once("vue/resultDeta.php");
							}
							else
							{
								include_once("vue/resultEleve.php");
							}
						}
						else
						{
							include_once("vue/resultCla.php");
						}
					}
					else 
					{
						include_once("vue/resultExa.php");
					}
				}
				else 
				{
					include_once("vue/resultat.php");
				}
			}
			else if($_GET['enc']=='pub')
			{
				if(isset($_GET['type']))
				{
					include_once("vue/montrerAnnonce.php");
				}
				else
				{
					include_once("vue/gestionAnnonce.php");
				}
			}
			else if($_GET['enc']=='ecoEl')
			{
				include_once("vue/actionEleve/gestionEcollage.php");
			}
			else if($_GET['enc']=='reinEl')
			{
				include_once("vue/actionEleve/reinscription.php");
			}
			else if($_GET['enc']=='pay')
			{
				include_once("vue/actionDir/paye.php");
			}
			else if ($_GET['enc']=='profil') {
				if(isset($_GET['t']))
				{
					$me = $membre->getMembre();
					if($_GET['t']=='adm')
					{
						include_once("vue/actionAdmin/profil.php");
					}
					else if($_GET['t']=='prof')
					{
						include_once("vue/actionProf/profil.php");
					}
					else if($_GET['t']=='elv')
					{
						include_once("vue/actionEleve/profil.php");
					}
					else 
					{
						include_once("vue/err.php");
					}
				}
			}
			else 
			{
				include_once("vue/err.php");
			}
		}
		else if(isset($_GET['id']) && isset($_GET['perso']))
		{
			if(isset($_GET['t']))
			{
				if($_GET['t']=='cl')
				{	
					$prof = giveDataClas($_GET['id'], $_GET['perso']);
					if(isset($prof['valider']) && $prof['valider'])
					{
						include_once("vue/actionAdmin/profilClasse.php");
					}
					else 
					{
						include_once("vue/actionAdmin/profNI.php");
					}
				}
				else if($_GET['t']=='mat')
				{
					$prof = giveDataMat($_GET['id'], $_GET['perso']);
					$toutClasse = $membre->donnerClasse();
					if(isset($prof['valider']) && $prof['valider'])
					{
						include_once("vue/actionAdmin/profilMatiere.php");
					}
					else 
					{
						include_once("vue/actionAdmin/profNI.php");
					}
				}
				else if($_GET['t']=='elv')
				{
					$prof = giveDataElv($_GET['id'], $_GET['perso']);
					if(isset($prof['valider']) && $prof['valider'])
					{
						include_once("vue/actionDir/profilEleve.php");
					}
					else 
					{
						include_once("vue/actionAdmin/profNI.php");
					}
				}
				else if($_GET['t']=='re')
				{
					$prof = giveDataElv($_GET['id'], $_GET['perso']);
					if(isset($prof['valider']) && $prof['valider'])
					{
						include_once("vue/actionDir/profilEleveRe.php");
					}
					else 
					{
						include_once("vue/actionAdmin/profNI.php");
					}
				}
				else 
				{
					$prof = giveDataDir($_GET['id'], $_GET['perso']);
					if(isset($prof['valider']) && $prof['valider'])
					{
						include_once("vue/actionAdmin/profilDirection.php");
					}
					else 
					{
						include_once("vue/actionAdmin/profNI.php");
					}
				}
			}
			else 
			{
				$prof = giveDataProf($_GET['id'], $_GET['perso']);
				$toutMat = $membre->donnerMatiere();
				$toutClasse = $membre->donnerClasse();
				if(isset($prof['valider']) && $prof['valider'])
				{
					include_once("vue/actionAdmin/profilProf.php");
				}
				else 
				{
					include_once("vue/actionAdmin/profNI.php");
				}
			}
		}
		else 
		{
			include_once("vue/admAccueil.php");
		}
	}
	else 
	{
		include_once("vue/acceuil.php");
	}