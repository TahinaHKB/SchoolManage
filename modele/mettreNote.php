<?php
	session_start();
	include_once("fonction.php");
	include_once("admi.class.php");
	include_once("infoAdm.php");
	include_once("admi.class.php");
	include_once("infoProf.php");
	$info = giveData($_SESSION['Id'], $_SESSION['Type']);
		$membre = new Admin($info);
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
    <link href="../style/heroes.css" rel="stylesheet">
<?php
	$header = ob_get_clean();
	ob_start();
	$req = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");
$sco = $req->fetch();
$req = $bdd->query("SELECT * FROM examen WHERE Etat=1");
$exam = $req->fetch();
	$title = "Note";
	$req = $bdd->prepare("SELECT * FROM eleve WHERE Classe=:c");
	$req->execute(array(
		"c" => $_POST['idC']
	));
	$eleve = $req->fetchAll();
	$rech = $bdd->prepare("SELECT Coefficient FROM correspondance WHERE Classe=:c AND Matiere=:m");
	$rech->execute(array(
		"c" => $_POST['idC'],
		"m" => $_POST['idM']
	));
	$coef = $rech->fetch();
	$r = $bdd->prepare("SELECT * FROM note WHERE Classe=:c AND Matiere=:m AND Scolaire=:s AND Examen=:e");
	$r->execute(array(
		"c" => $_POST['c'],
		"m" => $_POST['mat'],
		"s" => $sco['Id'],
		"e" => $exam['Id']
	));
	$nb = $r->rowCount();
	ob_start();
	?>
	<div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Eleve</th>
            <th scope="col">Coefficient</th>
            <th scope="col">Note(/20)</th>
          </tr>
          </thead>
          <tbody>
	<?php
	if($nb>0)
	{
		$data = $r->fetchAll();
		foreach($data as $key => $value)
		{
			$sur = 20;
			?>
				<tr>
					<th><?=$value['Eleve']?></th>
					<td><?=$coef['Coefficient']?></td>
					<td><?=round($value['Chiffre'], 2)?></td>
			</tr>
			<?php
		}
	}
	else 
	{
	?>
	<form action="insererNote.php" method="POST">
	<?php
	foreach ($eleve as $key => $value) {
		?>
		<tr><th><label id="<?=$value['Appelation']?>"><?=$value['Appelation']?></th></label>
			<td><?=$coef['Coefficient']?></td>
			<td>
		<input type="float" name="<?=$value['Appelation']?>" id="<?=$value['Appelation']?>" required>/20</br>
			</td>
	</tr>
		<?php
	}
	?>
		<input type="hidden" name="coef" value=<?=$coef['Coefficient']?>>
		<input type="hidden" name="idC" value="<?=$_POST['idC']?>">
 		<input type="hidden" name="mat" value="<?=$_POST['mat']?>">
 		<input type="hidden" name="c" value="<?=$_POST['c']?>">
 		<input type="submit" value="Envoyer">
	</form>
<?php } ?>
		</tbody>
	</table>
	</div>
	<a href="../main.php?enc=not">Retour</a>
<?php
	$contenue = ob_get_clean();
	$page ='Note>'.$_POST['c'].'>'.$_POST['mat'];
	include_once("../vue/template3.php");