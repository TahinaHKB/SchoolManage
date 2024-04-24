<?php
	$title = "Resultat";
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
	$req = $bdd->prepare("SELECT * FROM annee_scolaire WHERE Id=:s");
	$req->execute(array(
		"s" => $_GET['sco']
	));
	$sco = $req->fetch();
	$req = $bdd->prepare("SELECT * FROM examen WHERE Id=:s");
	$req->execute(array(
		"s" => $_GET['exa']
	));
	$exa = $req->fetch();
	$req = $bdd->prepare("SELECT SUM(Chiffre*Coefficient) as total, SUM(Coefficient) as coef, Eleve FROM note WHERE Examen=:e AND Classe=:c GROUP BY Eleve ORDER BY total DESC");
	$req->execute(array(
		"e" => $_GET['exa'],
		"c" => $_GET['cla']
	));
	$eleve = $req->fetchAll();
	?>
	<div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Rang</th>
            <th scope="col">Eleve</th>
            <th scope="col">Moyenne</th>
          </tr>
          </thead>
          <tbody>
	<?php
		$rang = 1;
		foreach ($eleve as $key => $value) {
		?><tr>
			<th><?= $rang?></th>
			<td><a href="main.php?enc=resu&sco=<?=$_GET['sco']?>&exa=<?=$_GET['exa']?>&cla=<?=$_GET['cla']?>&el=<?=$value['Eleve']?>"><?= $value['Eleve'].'</a>' ?></td>
			<td><?=round($value['total']/$value['coef'],2)?> </td>
			</tr>
		<?php
		}
	?>
		</tbody>
	</table>
	</div>
<a href="main.php?enc=resu&sco=<?=$_GET['sco']?>&exa=<?=$_GET['exa']?>">Retour</a>
<script type="text/javascript">
			var lien = document.getElementById("resu");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Resultat>'.$sco['Nom'].'>'.$exa['Nom'].'>'.$_GET['cla'].'>Eleve';
	include_once("template2.php");