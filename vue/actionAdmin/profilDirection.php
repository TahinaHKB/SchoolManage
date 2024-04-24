<?php
	$title = "Profil"; $header = '';
	$appelation = preg_replace("#_#", " ", $prof['Appelation']);
	ob_start();
	if(isset($_SESSION['pResult']) && $_SESSION['pResult']<>'')
	{
		?>
		<p class="list-group-item list-group-item-action list-group-item-success"><?=$_SESSION['pResult']?></p>
		<?php
					$_SESSION['pResult'] = '';
	}
?>
	<div><img src="image/adm/<?= $prof['Photo'] ?>" width="100px"></div>
	<h1> <?= $appelation ?> </h1>
	<ul>
		<li>
			<form method="POST" action="modele/mettreAjourDir.php">
				<label>Renumeration :</label>
				<input type="number" name="renum" id="renum" value="<?= $prof['Renumeration'] ?>">
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
				<input type="hidden" name="type" value="renum">
				<input type="submit" value="modifier">
				<?php 
				if(isset($_SESSION['pResult']))
				{
					echo '  '.$_SESSION['pResult'];
					$_SESSION['pResult'] = '';
				}
				?>
			</form>
		</li>
		<li>Adresse : <?= $prof['Adresse'] ?></li>
		<li>Numéro de telephone : <?= $prof['Numero'] ?></li>
		<li>Email : <?= $prof['Email'] ?></li>
		<li>Date d'embauche : <?= $prof['DateDebut'] ?></li>
	</ul>
	<a href="main.php?enc=sup&id=<?=$prof['Id']?>&perso=<?=$prof['Appelation']?>&t=d">
		<input class="btn btn-primary" value="Supprimer <?=$appelation?> ">
	</a>
	</br></br>
	<a href="main.php?enc=drt">
		<input class="btn btn-primary" value="Retour">
	</a>
	<script type="text/javascript">
			var lien = document.getElementById("dir");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Profil > '.$appelation;
	include_once("vue/template2.php");