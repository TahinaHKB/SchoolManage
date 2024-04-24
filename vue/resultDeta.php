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
	$req = $bdd->prepare("SELECT * FROM note WHERE Examen=:e AND Classe=:c AND Eleve=:el");
	$req->execute(array(
		"e" => $_GET['exa'],
		"c" => $_GET['cla'],
		"el" => $_GET['el']
	));
	$eleve = $req->fetchAll();
	$num = 0; $den = 0;
	?>
	<div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Matière</th>
            <th scope="col">Coefficient</th>
            <th scope="col">Note</th>
          </tr>
          </thead>
          <tbody>
	<?php
		foreach ($eleve as $key => $value) {
					$n = 20; 
					$num += $value['Chiffre']*$value['Coefficient'];
					$den += $value['Coefficient'];
		?><tr>
			<th><?= $value['Matiere']?></th>
			<td><?= $value['Coefficient']?></td>
			<td><?=$value['Chiffre']*$value['Coefficient']?> </td>
			</tr>
		<?php
		}
		$moyenne = $num/$den;
		$vraiTotal = (20*$num)/$moyenne;
	?>
		<tr>
			<th>Total</th>
			<td><?=$den?></td>
			<td><?=$num?></td>
		</tr>
		<tr>
			<th colspan="2">Moyenne</th>
			<th><?=round($moyenne,2)?></th>
		</tr>
		</tbody>
	</table>
	</div>
<a href="main.php?enc=resu&sco=<?=$_GET['sco']?>&exa=<?=$_GET['exa']?>&cla=<?=$_GET['cla']?>">Retour</a>
<?php
	$contenue = ob_get_clean();
	$page = 'Resultat>'.$sco['Nom'].'>'.$exa['Nom'].'></br>'.$_GET['cla'].'>'.$_GET['el'];
	include_once("template2.php");