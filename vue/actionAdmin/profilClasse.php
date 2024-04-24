<?php
	$title = "Classe"; $header='';
	ob_start();
	$don1 = $bdd->query("SELECT * FROM professeur");
	$professeur = $don1->fetchAll();
	$don2 = $bdd->query("SELECT * FROM classe");
	$classe = $don2->fetchAll();
	$rech = $bdd->prepare("SELECT m.Id matI, c.Coefficient coef, m.Nom nomMat FROM correspondance c INNER JOIN matiere m ON c.Matiere=m.Id WHERE c.Classe=:i");
	$rech->execute(array(
		"i" => $_GET['id']
	));
	$mat = $rech->fetchAll();
?>
	<h1>INFORMTAIONS</h1>
	<?php 
			if(isset($_SESSION['pResult']))
			{
					echo '  '.$_SESSION['pResult'];
					$_SESSION['pResult'] = '';
				}
				?>
	<ul>
		<li>
			<form method="POST" action="modele/mettreAjourClasse.php">
				<label for="renum">Capacité :</label>
				<input type="number" name="capacite" id="renum" value="<?= $prof['PlaceMax'] ?>">
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Nom']?>">
				<input type="hidden" name="type" value="place">
				<input type="submit" value="modifier">
			</form>
		</li>
		<li>
			<form method="POST" action="modele/mettreAjourClasse.php">
				<label for="tit">Titulaire :</label>
				<select id="tit" name="titulaire">
					<option value="0" <?php if($prof['Titulaire']==0){echo 'selected';}?>>Aucun</option>
					<?php
						foreach ($professeur as $key => $value) {
							$in = true;
							foreach ($classe as $key2 => $value2) {
								if($value['Id']==$value2['Titulaire'])
								{
									$in = false;
								}
							}
							if($value['Id']==$prof['Titulaire'])
							{
								echo "<option value='".$value['Id']."' selected>".$value['Appelation']."</option>";
							}
							else if($in)
							{
								echo "<option value='".$value['Id']."'>".$value['Appelation']."</option>";
							}
						}
					?>
				</select>
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Nom']?>">
				<input type="hidden" name="type" value="Titulaire">
				<input type="submit" value="modifier">
			</form>
				
		</li>
		<li>Nombre d'élèves : <?= $prof['Eleve'].'/'.$prof['PlaceMax'] ?></li>
	</ul>
	<div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Matiere</th>
            <th scope="col">Coefficient</th>
            <th scope="col">Professeur</th>
          </tr>
          </thead>
          <tbody>
	<?php
		foreach ($mat as $data => $values) {
			$rech = $bdd->prepare("SELECT p.Id idP, p.Appelation appelP FROM professeur p INNER JOIN enseigne e ON p.Id=e.Professeur WHERE e.Classe=:i AND e.Matiere = :m");
				$rech->execute(array(
					"i" => $_GET['id'],
					"m" => $values['matI']
				));

					$dons = $rech->fetch();
			?>
				<tr>
					<td><?= $values['nomMat'] ?></td>
					<td><?= $values['coef'] ?></td>
					<td>
						<?php
		   			if($rech->rowCount()==1)
					{
						?>
							<a href="main.php?id=<?=$dons['idP']?>&perso=<?=$dons['appelP']?>"><?= $dons['appelP'] ?></a>
						<?php
					}
					else 
					{
						echo 'aucun enseignant';
					}
				?>
					</td>
				</tr>
			<?php
		}
	?>
		</tbody>
	</table>
	</div>
	<?php
		$req = $bdd->prepare("SELECT * FROM eleve WHERE Classe=:c");
		$req->execute(array(
			"c" => $prof['Id']
		));
		if($req->rowCount()==0)
		{
	?>
	<a href="main.php?enc=sup&id=<?=$prof['Id']?>&perso=<?=$prof['Nom']?>&t=cl">
		<input class="btn btn-primary" value="Supprimer <?= $prof['Nom'].' '.$prof['Identifiant'] ?>">
	</a></br></br>
<?php } ?>
	<a href="main.php?enc=cla">
		<input class="btn btn-primary" value="Retour">
	</a></br>
	<script type="text/javascript">
			var lien = document.getElementById("cla");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Classe > '.$prof['Nom'].' '.$prof['Identifiant'];
	include_once("vue/template2.php");