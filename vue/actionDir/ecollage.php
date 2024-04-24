<?php
	$title = "Ecollage";
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

	$rech = $bdd->query("SELECT * FROM annee_scolaire");
	$scolaire = $rech->fetchAll();
	foreach($scolaire as $key => $value)
	{
	?>
		<h3>Année scolaire <?= $value['Nom'].' : '.$value['DateDebut'].' à ' ?>
				<?php
					if($value['Etat'])
					{
						echo 'En cours';
					} 
					else 
					{
						echo $value['DateFin'];
					}
				?>
		</h3>
		<form action="modele/payerEcollage.php" method="POST">
	<?php
		$req = $bdd->prepare("SELECT * FROM ecollage WHERE Eleve=:e AND scolaire=:s");
		$req->execute(array(
			"e" => $prof['Appelation'],
			"s" => $value['Id']
		));
		$ecollage = $req->fetchAll();
		$req = $bdd->query("SELECT * FROM mois");
		$mois = $req->fetchAll();

		foreach($mois as $key => $m)
		{
			$in = false;
			foreach($ecollage as $key => $e)
			{
				if($m['Id']==$e['Mois'])
				{
					$in = true;
				}
			}
			if($in)
			{
				?>
				<span><?=$m['Nom']?>(Payé)&nbsp;</span>
				<?php
			}
			else 
			{
				?>
				<input type="checkbox" name="<?=$m['Id']?>" id="<?=$m['Nom']?>">
				<lable for="<?=$m['Nom']?>"><?=$m['Nom']?></lable>
				<?php
			}
		}
?>
		<input type="hidden" name="Id" value="<?=$prof['Id']?>">
		<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
		<input type="hidden" name="type" value="renum">
		<input type="hidden" name="scolaire" value="<?=$value['Id']?>">
		<input type="submit" name="Envoyer">
	</form>
<?php
	}
?>
	<a href="main.php?t=elv&id=<?=$prof['Id']?>&perso=<?=$prof['Appelation']?>">Retour</a>
	<script type="text/javascript">
			var lien = document.getElementById("e");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Ecollage>'.$prof['Appelation'];
	include_once("vue/template2.php");