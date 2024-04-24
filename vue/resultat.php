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
	$req = $bdd->query("SELECT s.Id Id, s.Nom sNom, s.DateDebut dD, s.DateFin dF, s.Etat etat FROM note INNER JOIN annee_scolaire s ON s.Id=note.Scolaire GROUP BY Scolaire");
	$data = $req->fetchAll();
	?>
	<div class="album py-5 bg-light">
    <div class="container">
    	<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 g-4">
    		<?php
	foreach ($data as $key => $value) {
?>
		<div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em"><?= $value['sNom'] ?></text></svg>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="main.php?enc=resu&sco=<?=$value['Id']?>"><button type="button" class="btn btn-sm btn-outline-secondary">Voir</button></a>
                </div>
                <small class="text-muted"><?= $value['dD'].' à ' ?>
				<?php
					if($value['etat'])
					{
						echo 'En cours';
					} 
					else 
					{
						echo $value['dF'];
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
<script type="text/javascript">
			var lien = document.getElementById("resu");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = "Resultat > Année scolaire";
	include_once("template2.php");