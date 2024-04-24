<?php
	$title = "Administrateur";
	ob_start();
?>
<style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="style/heroes.css" rel="stylesheet">
<?php
	$header = ob_get_clean();
	ob_start();
?>
<li class="nav-item">
      <a class="nav-link" id="actu" href="main.php">
        <span data-feather="file"></span>
        Actualités
    </a>
  </li>
<?php
	if($membre->testerStatue())
	{
		$pub = "administrateur";
?>
	<li class="nav-item">
      <a class="nav-link" href="main.php?enc=prf" id="prof">
        <span data-feather="file"></span>
        Gestion des professeurs
    </a>
  </li>
  <li class="nav-item">
      <a class="nav-link" href="main.php?enc=drt" id="dir">
        <span data-feather="file"></span>
        Membres de la direction
    </a>
  </li>
  <li class="nav-item">
      <a class="nav-link" href="main.php?enc=cla" id="cla">
        <span data-feather="file"></span>
        Gestion des classes
    </a>
  </li>
  <li class="nav-item">
      <a class="nav-link" href="main.php?enc=mat" id="mat">
        <span data-feather="file"></span>
        Matière
    </a>
  </li>
  <li class="nav-item">
      <a class="nav-link" href="main.php?enc=sco" id="sco">
        <span data-feather="file"></span>
        Annee scolaire
    </a>
  </li>
  <li class="nav-item">
      <a class="nav-link" href="main.php?enc=pub" id="pub">
        <span data-feather="file"></span>
        Créer une annonce
    </a>
  </li>
	<?php $_SESSION['profil'] = 'main.php?enc=profil&t=adm'; ?>
	<?php
			$req = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");
			$exa = $req->rowCount();
			if($exa==1)
			{
			?>
	<li class="nav-item">
      <a class="nav-link" href="main.php?enc=exa" id="exa">
        <span data-feather="file"></span>
        Examen
    </a>
  </li>
			<?php
			}

	?>
<?php }
	else 
	{
		if($membre->getCompte()=='adm')
		{
			$pub = "administrateur";
			?>
	<li class="nav-item">
      <a class="nav-link" href="main.php?enc=elv" id="e">
        <span data-feather="file"></span>
        Gestion eleve
    </a>
  </li>
	<li class="nav-item">
      <a class="nav-link" href="main.php?enc=pub" id="pub">
        <span data-feather="file"></span>
        Créer une annonce
    </a>
  </li>
	<li class="nav-item">
      <a class="nav-link" href="main.php?enc=pay" id="pay">
        <span data-feather="file"></span>
        Payement par mobile
    </a>
  </li>
  <?php $_SESSION['profil'] = 'main.php?enc=profil&t=adm'; ?>
			<?php
		}
		else if($membre->getCompte()=='prof')
		{
			?>
	<?php $_SESSION['profil'] = 'main.php?enc=profil&t=prof'; ?>
			<?php
			$pub = "administrateur";
			$_SESSION['me']= $membre->getMembre();
			$req = $bdd->query("SELECT * FROM examen WHERE Etat=1");
			$exa = $req->rowCount();
			if($exa==1)
			{
			?>
	<li class="nav-item">
      <a class="nav-link" href="main.php?enc=not" id="note">
        <span data-feather="file"></span>
        Note
    </a>
  </li>
			<?php
			}
		}
		else if($membre->getCompte()=='eleve')
		{
			?>
      <?php $_SESSION['profil'] = 'main.php?enc=profil&t=elv'; ?>
			<?php
			$pub = "eleve";
			$req = $bdd->prepare("SELECT MAX(scolaire) as sco FROM ecollage WHERE Eleve=:e");
		$req->execute(array(
			"e" => $membre->getAppelation()
		));
			$sco = $req->fetch();
			$req = $bdd->prepare("SELECT * FROM ecollage WHERE Eleve=:e AND scolaire=:s");
		$req->execute(array(
			"e" => $membre->getAppelation(),
			"s" => $sco['sco']
		));
			$nb = $req->rowCount();
			$req = $bdd->prepare("SELECT MAX(Scolaire) as s FROM note WHERE Eleve=:el");
	$req->execute(array(
		"el" => $membre->getAppelation()
	));
	$s = $req->fetch();

	$req = $bdd->prepare("SELECT * FROM note WHERE Eleve=:el AND Scolaire=:s");
	$req->execute(array(
		"el" => $membre->getAppelation(),
		"s" => $s['s']
	));
	$eleve = $req->fetchAll();
	$num = 0; $den = 0;
	foreach ($eleve as $key => $value) {
					$n = 20; 
					$num += $value['Chiffre']*$value['Coefficient'];
					$den += $value['Coefficient'];	
	}
		$moyenne = $num/$den;
		$vraiTotal = (20*$num)/$moyenne;
		$_SESSION['moyenne'] = $moyenne;
		$req = $bdd->prepare("SELECT * FROM payement WHERE Eleve=:el AND Type='reinscription'");
	$req->execute(array(
		"el" => $membre->getMembre()['Id']
	));
	$nb2 = $req->rowCount();

	$req = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");
	$nb3 = $req->rowCount();
	if($nb3==1 && $membre->getMembre()['Classe']<>36)
	{
			?>
	<li class="nav-item">
      <a class="nav-link" href="main.php?enc=ecoEl" id="eco">
        <span data-feather="file"></span>
        Ecollage
    </a>
  </li>	
			<?php
		}
			if($moyenne>10 && $nb>=8 && $nb2==0 && $membre->getMembre()['Classe']==36)
			{
				?>
				<li class="nav-item">
      <a class="nav-link" href="main.php?enc=reinEl" id="rein">
        <span data-feather="file"></span>
        Reinscriptions
    </a>
  </li>
				<?php
			}
		}
	}
	?>
	<li class="nav-item">
      <a class="nav-link" href="main.php?enc=resu" id="resu">
        <span data-feather="file"></span>
        Voir les resultats
    </a>
  </li>

<?php
	$_SESSION['menu'] = ob_get_clean();
	$page = "Publications récents";
	ob_start();
	$req = $bdd->prepare("SELECT * FROM publications WHERE Audiance=:a ORDER BY Id DESC LIMIT 0, 15 ");
	$req->execute(array(
		"a" => $pub
	));
	$nb = $req->rowCount();
	if($nb>0)
	{
	$data = $req->fetchAll();
	foreach ($data as $key => $value) {
	?>
	<div class="px-4 pt-5 my-5 text-center border-bottom">
    <h1 class="display-4 fw-bold"><?=$value['Auteur'].' : '.$value['Titre']?></h1>
    <div class="col-lg-6 mx-auto">
      <p><?=$value['Contenu']?></p>
    </div>
    <div class="overflow-hidden" style="max-height: 30vh;">
      <div class="container px-5">
      	<?php if($value['Image']<>''){?><img src="image/pub/<?=$value['Image']?>" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy"><?php } ?>
      </div>
    </div>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
        <i><?=$value['Dates']?></i>
      </div>
  </div>
  	<?php	
	}
	}
	else 
	{
		?>
		<div class="px-4 pt-5 my-5 text-center border-bottom">
    <div class="col-lg-6 mx-auto">
      <p>Aucun publications pour le moment :(</p>
    </div>
  </div>
		<?php
	}
	?>	
		<script type="text/javascript">
			var lien = document.getElementById("actu");
			lien.className = "nav-link active";
		</script>
	<?php
	$contenue = ob_get_clean();
	include_once("template2.php");