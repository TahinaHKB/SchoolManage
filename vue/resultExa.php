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
	$req = $bdd->prepare("SELECT * FROM examen WHERE Scolaire=:s  AND Etat=0");
	$req->execute(array(
		"s" => $_GET['sco']
	));
	$examen = $req->fetchAll();
	?>
	<div class="album py-5 bg-light">
    <div class="container">
    	<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 g-4">
    		<?php
	foreach ($examen as $key => $value) {
?>
		<div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em"><?= $value['Nom'] ?></text></svg>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="main.php?enc=resu&sco=<?=$_GET['sco']?>&exa=<?=$value['Id']?>"><button type="button" class="btn btn-sm btn-outline-secondary">Voir</button></a>
                </div>
                <small class="text-muted"><?= $value['DateDebut'].' à ' ?>
				<?php
					if($value['Etat'])
					{
						echo 'En cours';
					} 
					else 
					{
						echo $value['DateFin'];
					}
				?></small>
              </div>
            </div>
          </div>
        </div>
<?php
	}
?>
    </div>
    </div>
   </div>
<a href="main.php?enc=resu">Retour</a>
<script type="text/javascript">
			var lien = document.getElementById("resu");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Resultat>'.$sco['Nom'].'>Examen';
	include_once("template2.php");