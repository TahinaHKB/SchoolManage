<?php
	$title = "Matiere"; $header = '';
	$req = $bdd->prepare("SELECT c.Coefficient coef, cl.Nom nomClasse, cl.Identifiant idClasse FROM correspondance c INNER JOIN classe cl ON cl.Id=c.Classe WHERE c.Matiere=:m");
	$req->execute(array(
		"m" => $_GET['id']
	));
	$classe = $req->fetchAll();

	$req2 = $bdd->query("SELECT c.Classe cla, c.Matiere matiere, c.Coefficient coef, cl.Nom nomClasse, cl.Identifiant idClasse FROM correspondance c RIGHT JOIN classe cl ON cl.Id=c.Classe");
	$infor = $req2->fetchAll();
	ob_start();
	if(isset($_SESSION['pResult']))
	{
		echo $_SESSION['pResult'];
		$_SESSION['pResult'] = '';
	}
?>
	<form method="POST" action="modele/mettreAjourMat.php">
	<?php
		foreach($infor as $key => $value)
		{
			if($value['matiere']==$_GET['id'])
			{
	?>
			<label for="<?=$value['nomClasse'].$value['idClasse']?>"><?=$value['nomClasse'].$value['idClasse']?></label>
			<input type="checkbox" name="<?=$value['nomClasse'].$value['idClasse']?>" id="<?=$value['nomClasse'].$value['idClasse']?>" checked> &nbsp;&nbsp;
	<?php 
			}
		}
	?>
	<?php
		foreach($toutClasse as $key => $value)
		{
			$in = false;
			foreach($infor as $key => $value2)
			{
				if($value2['nomClasse'].$value2['idClasse']==$value['Nom'].$value['Identifiant'] && $value2['matiere']==$_GET['id'])
				{
					$in = true;
				}
			}
			if(!$in)
			{
	?>
			<label for="<?=$value['Nom'].$value['Identifiant']?>"><?=$value['Nom'].$value['Identifiant']?></label>
			<input type="checkbox" name="<?=$value['Nom'].$value['Identifiant']?>" id="<?=$value['Nom'].$value['Identifiant']?>"> &nbsp;&nbsp;
	<?php 
			}
		}
	?>
	<input type="hidden" name="Id" value="<?=$_GET['id']?>">
	<input type="hidden" name="perso" value="<?=$_GET['perso']?>">
	<input type="hidden" name="type" value="classe">
	<input type="submit" value="Modifier">
	</form>
	
	<form method="POST" action="modele/mettreAjourMat.php">
	<div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Classe</th>
            <th scope="col">Coefficient</th>
          </tr>
          </thead>
          <tbody>
	<?php
		foreach ($classe as $key => $value) {
			
			?>
				<tr>
					<td><label><?=$value['nomClasse'].$value['idClasse'].' : '?></label></td>
					<td><input type="number" name="<?=$value['nomClasse'].$value['idClasse']?>" value="<?=$value['coef']?>"></td>
				</tr>
			<?php
		}
	?>
		</tbody>
	</table>
	</div>
	<input type="hidden" name="Id" value="<?=$_GET['id']?>">
	<input type="hidden" name="perso" value="<?=$_GET['perso']?>">
	<input type="hidden" name="type" value="coefficient">
	<input type="submit" value="Modifier">
	</form>
	<a href="main.php?enc=sup&id=<?=$_GET['id']?>&perso=<?=$_GET['perso']?>&t=mat">
		<input class="btn btn-primary" value="Supprimer <?=$_GET['perso']?> des matières">
	</a></br></br>
	<a href="main.php?enc=mat">
		<input class="btn btn-primary" value="Retour">
	</a>
	<script type="text/javascript">
			var lien = document.getElementById("mat");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = "Matiere > ".$prof['Nom'];
	include_once("vue/template2.php");