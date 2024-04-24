<?php
	$title = "Re-inscription";
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
	$_SESSION['idC'] = $prof['Classe'];
?>
	<h1>Reinscription</h1>
	<div><img src="image/eleve/<?= $prof['Photo'] ?>" width="100px"></div>
	<h1>Profil de <?= $appelation ?> </h1>
	<ul>
		<li>
			<form method="POST" action="modele/mettreAjourEleve.php">
				<label for="classe">Classe : </label>
				<select name="classe" id="classe">
				<?php
					foreach ($clas as $key => $value) 
					{
						if($value['Id']!=36)
						{
				?>
					<option value="<?=$value['Id']?>" <?php if($prof['Classe']==$value['Id']){echo 'selected';} ?>><?=$value['Nom'].$value['Identifiant']?></option>
				<?php
						}
					}
				?>
				</select>
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
				<input type="hidden" name="type" value="reinscrire">
				<input type="submit" value="Reinscrire">
			</form>
		</li>
		<li>Adresse : <?= $prof['Adresse'] ?></li>
		<li>Numéro de telephone : <?= $prof['Numero'] ?></li>
		<li>Email : <?= $prof['Mail'] ?></li>
		<li>Date d'entrée : <?= $prof['Dates'] ?></li>
	</ul>

	<?php
	$req = $bdd->prepare("SELECT MAX(Scolaire) as s FROM note WHERE Eleve=:el");
	$req->execute(array(
		"el" => $prof['Appelation']
	));
	$s = $req->fetch();

	$req = $bdd->prepare("SELECT * FROM note WHERE Eleve=:el AND Scolaire=:s");
	$req->execute(array(
		"el" => $prof['Appelation'],
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
	?>
	<p>
		=> Total general de l'année scolaire prédante: <?=$num.'/'.$vraiTotal?> </br>
		=> Moyenne général : <?=round($moyenne,2).'/20'?> </br>
		=> Ancienne classe : <?=$value['Classe']?>
	</p>
	<a href="main.php?enc=eco&id=<?=$prof['Id']?>&perso=<?=$prof['Appelation']?>">Ecollage de <?=$appelation?></a></br>
	<a href="main.php?enc=sup&id=<?=$prof['Id']?>&perso=<?=$prof['Appelation']?>&t=elv">Supprimer <?=$appelation?> des élèves </a></br>
	<a href="main.php?t=elv&id=<?=$prof['Id']?>&perso=<?=$prof['Appelation']?>">Annuler</a>
	<script type="text/javascript">
			var lien = document.getElementById("e");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Reinscription>'.$prof['Appelation'];
	include_once("vue/template2.php");