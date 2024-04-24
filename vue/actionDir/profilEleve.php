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
	$appelation = preg_replace("#_#", " ", $prof['Appelation']);
	$rech = $bdd->query("SELECT * FROM classe WHERE Eleve<PlaceMax ORDER BY Nom AND Identifiant");
	$clas = $rech->fetchAll();
	$req = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");
	$nb = $req->rowCount();
?>
	<div><img src="image/eleve/<?= $prof['Photo'] ?>" width="100px"></div>
	<h1><?= $appelation ?> </h1>
	<ul>
		<?php
			if($prof['Classe']!=36)
			{
		?>
		<li>
			<form method="POST" action="modele/mettreAjourEleve.php">
				<label for="classe">Classe : </label>
				<select name="classe" id="classe">
				<?php
					foreach ($clas as $key => $value) 
					{
				?>
					<option value="<?=$value['Id']?>" <?php if($prof['Classe']==$value['Id']){echo 'selected';} ?>><?=$value['Nom'].$value['Identifiant']?></option>
				<?php
					}
				?>
				</select>
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
				<input type="hidden" name="type" value="renum">
				<input type="submit" value="modifier">
			</form>
		</li>
		<?php
			}
			else if($nb==1)
			{
				?>
					<a href="main.php?t=re&id=<?=$prof['Id']?>&perso=<?=$prof['Appelation']?>">Ré-inscrire</a>
				<?php
			}
		?>
		<li>Adresse : <?= $prof['Adresse'] ?></li>
		<li>Numéro de telephone : <?= $prof['Numero'] ?></li>
		<li>Email : <?= $prof['Mail'] ?></li>
		<li>Date d'entrée : <?= $prof['Dates'] ?></li>
	</ul>

	<a href="main.php?enc=eco&id=<?=$prof['Id']?>&perso=<?=$prof['Appelation']?>">Ecollage de <?=$appelation?></a></br>
	<a href="main.php?enc=sup&id=<?=$prof['Id']?>&perso=<?=$prof['Appelation']?>&t=elv">Supprimer <?=$appelation?> des élèves </a></br>
	<a href="main.php?enc=clEl&id=<?=$_SESSION['IdC']?>&perso=<?=$_SESSION['NomC']?>">Retour</a>
	<script type="text/javascript">
			var lien = document.getElementById("e");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Profil>'.$prof['Appelation'];
	include_once("vue/template2.php");