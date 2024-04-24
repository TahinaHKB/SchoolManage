<?php
	$title = "Note";
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
	$req = $bdd->prepare("SELECT m.Nom mat, m.Id idM FROM matiere m INNER JOIN connaissance c ON c.Matiere=m.Id WHERE c.Professeur=:i");
	$req->execute(array(
		"i" => $_SESSION['me']['Id']
	));
	$matiere = $req->fetchAll();
	foreach ($matiere as $key => $value) {
	?>
		<h3><?=$value['mat']?></h3>
	<?php
		$req2 = $bdd->prepare("SELECT c.Nom nClasse, c.Identifiant iClasse, c.Id idC FROM classe c INNER JOIN enseigne e ON e.Classe=c.Id WHERE e.Professeur=:p AND e.Matiere=:m");
		$req2->execute(array(
			"p" => $_SESSION['me']['Id'],
			"m" => $value['idM']
 		));
 		$classe = $req2->fetchAll();
 		foreach($classe as $key => $c)
 		{
 			?>
 				<form method="POST" action="modele/mettreNote.php">
 					<input type="hidden" name="idC" value="<?=$c['idC']?>">
 					<input type="hidden" name="idM" value="<?=$value['idM']?>">
 					<input type="hidden" name="mat" value="<?=$value['mat']?>">
 					<input type="hidden" name="c" value="<?=$c['nClasse'].$c['iClasse']?>">
 					<input type="submit" value="<?=$c['nClasse'].$c['iClasse']?>">
 				</form>
 			<?php
 		}
	}
?>

	<script type="text/javascript">
			var lien = document.getElementById("note");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Note';
	include_once("vue/template2.php");