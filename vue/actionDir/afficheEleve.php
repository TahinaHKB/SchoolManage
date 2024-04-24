<?php
	$title = "Eleve";
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
	$_SESSION['IdC'] = $cl['Id'];
	$_SESSION['NomC'] = $cl['Nom'];
	$_SESSION['IdentifiantC'] = $cl['Identifiant'];
	ob_start();
?>
<div class="album py-5 bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 g-5">
        <?php
  foreach ($eleve as $key => $value) {
    $appelation = preg_replace("#_#", " ", $value['Appelation']);
?>
    <div class="col">
          <div class="card shadow-sm">
            <img src="image/eleve/<?= $value['Photo'] ?>" width="100%">
            <div class="card-body">
              <p class="card-text"><?= $appelation ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="main.php?id=<?=$value['Id']?>&perso=<?=$value['Appelation']?>&t=elv"><button type="button" class="btn btn-sm btn-outline-secondary">Voir</button></a>
                </div>
                <small class="text-muted"><?=$value['Dates']?></small>
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
	<a href="main.php?enc=elv">Retour</a>
	<script type="text/javascript">
			var lien = document.getElementById("e");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = $cl['Nom'].$cl['Identifiant'].'>Eleve';
	include_once("vue/template2.php");