<?php
	$title = "Profil";
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
      #renums
      {
      	display: none;
      }
      #table
      {
      	width: 50%;
      	margin: 0 auto;
      	font-size: 10px;
      }
      .btn
      {
      	width: 70px;
      	height: 20px;
      	padding: 0;
      	font-size: 10px;
      }
      #pro
      {
      	width: 100%;
      	margin: 0 auto;
      	text-align: center;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
        #table
      	{
      		font-size: 20px;
      	}
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="style/heroes.css" rel="stylesheet">
<?php
	$header = ob_get_clean();
	$appelation = preg_replace("#_#", " ", $prof['Appelation']);
	$req2 = $bdd->query("SELECT m.Id matId, c.Professeur profe, m.Nom nomMatiere FROM connaissance c INNER JOIN matiere m ON m.Id=c.Matiere");
	$infor = $req2->fetchAll();
	ob_start();
	if(isset($_SESSION['pResult']) && $_SESSION['pResult']<>'')
	{
		?>
		<p class="list-group-item list-group-item-action list-group-item-success"><?=$_SESSION['pResult']?></p>
		<?php
					$_SESSION['pResult'] = '';
	}
?>
	<div><img src="image/prof/<?= $prof['photo'] ?>" width="100px"></div>
	<h1><?= $appelation ?> </h1>
	<ul>
		<li>
			<form method="POST" action="modele/mettreAjourProf.php">
				<label>Renumeration :</label>
				<input type="number" name="renum" id="renum" value="<?= $prof['Renumeration'] ?>">
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
				<input type="hidden" name="type" value="renum">
				<input type="submit" value="modifier">
			</form>
		</li>
		<li>Adresse : <?= $prof['Adresse'] ?></li>
		<li>Numéro de telephone : <?= $prof['Numero'] ?></li>
		<li>Email : <?= $prof['Email'] ?></li>
		<li>Date d'embauche : <?= $prof['Dates'] ?></li>
	</ul>

	<form method="POST" action="modele/mettreAjourProf.php">
	<?php
		foreach($infor as $key => $value)
		{
			if(isset($value['nomMatiere']) && $value['profe']==$_GET['id'])
			{
	?>
			<label for="<?=$value['nomMatiere']?>"><?=$value['nomMatiere']?></label>
			<input type="checkbox" name="<?=$value['nomMatiere']?>" id="<?=$value['nomMatiere']?>" checked> &nbsp;&nbsp;
	<?php 
			}
		}
	?>
	<?php
		foreach($toutMat as $key => $value)
		{
			$in = false;
			foreach($infor as $key => $value2)
			{
				if($value2['nomMatiere']==$value['Nom'] && $value2['profe']==$_GET['id'])
				{
					$in = true;
				}
			}
			if(!$in)
			{
	?>
			<label for="<?=$value['Nom']?>"><?=$value['Nom']?></label>
			<input type="checkbox" name="<?=$value['Nom']?>" id="<?=$value['Nom']?>"> &nbsp;&nbsp;
	<?php 
			}
		}
	?>
	<input type="hidden" name="Id" value="<?=$_GET['id']?>">
	<input type="hidden" name="perso" value="<?=$_GET['perso']?>">
	<input type="hidden" name="type" value="matiere">
	<input type="submit" value="Modifier">
	</form>
	<?php
		foreach($infor as $key => $value)
		{
			if($value['profe']==$_GET['id'])
			{	$existe = false;
				?>
				<form method="POST" action="modele/mettreAjourProf.php">
					<fieldset>
						<h3><?= $value['nomMatiere'] ?></h3>
				<?php
				$rechCl = $bdd->prepare("SELECT c.Nom nClasse, c.Identifiant iClasse FROM classe c INNER JOIN enseigne e ON c.Id=e.Classe WHERE e.Professeur=:p AND e.Matiere=:m");
				$rechCl->execute(array(
					"p" => $_GET['id'],
					"m" => $value['matId']
				));
				while($dons=$rechCl->fetch())
				{	$existe = true;
					?>
						<label for="<?=$dons['nClasse'].$dons['iClasse']?>"><?=$dons['nClasse'].$dons['iClasse']?></label>
						<input type="checkbox" name="<?=$dons['nClasse'].$dons['iClasse']?>" id="<?=$dons['nClasse'].$dons['iClasse']?>" checked> &nbsp;&nbsp;
					<?php
				}
				foreach($toutClasse as $key2 => $cl)
				{
					$rech = $bdd->prepare("SELECT * FROM enseigne WHERE Classe=:c AND Matiere=:m");
					$rech->execute(array(
						"c" => $cl['Id'],
						"m" => $value['matId']
					));
					$rech2 = $bdd->prepare("SELECT * FROM correspondance WHERE Classe=:c AND Matiere=:m");
					$rech2->execute(array(
						"c" => $cl['Id'],
						"m" => $value['matId']
					));
					if($rech->rowCount()==0 && $rech2->rowCount()==1)
					{	$existe = true;
						?>
							<label for="<?=$cl['Nom'].$cl['Identifiant']?>"><?=$cl['Nom'].$cl['Identifiant']?></label>
							<input type="checkbox" name="<?=$cl['Nom'].$cl['Identifiant']?>" id="<?=$cl['Nom'].$cl['Identifiant']?>"> &nbsp;&nbsp;
						<?php
					}
				}
				if(!$existe){echo 'Toutes les classes ont été prises pour cette matière.';}
				?>
						<input type="hidden" name="Id" value="<?=$_GET['id']?>">
						<input type="hidden" name="Matiere" value="<?=$value['matId']?>">
						<input type="hidden" name="perso" value="<?=$_GET['perso']?>">
						<input type="hidden" name="type" value="classe">
						<?php if($existe){ ?>
						<input type="submit" value="Modifier">
					<?php } ?>
					</fieldset>
				</form>
				<?php

			}
		}
	?>

	<a href="main.php?enc=sup&id=<?=$prof['Id']?>&perso=<?=$prof['Appelation']?>">
		<input class="btn btn-primary" value="Supprimer <?=$appelation?> des professeurs ">
	</a></br>
	<a href="main.php?enc=prf">
		<input class="btn btn-primary" value="Retour">
	</a>
	<script type="text/javascript">
			var lien = document.getElementById("prof");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page ='Profil > '.$appelation;
	include_once("vue/template2.php");