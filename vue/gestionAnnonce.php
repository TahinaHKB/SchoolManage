<?php
	$title = "Annonce";
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
	$req = $bdd->query("SELECT * FROM matiere");
	$mat = $req->fetchAll();
	ob_start();
	if(isset($_SESSION['pResult']) && $_SESSION['pResult']<>'')
	{
		?>
		<p class="list-group-item list-group-item-action list-group-item-success"><?=$_SESSION['pResult']?></p>
		<?php
					$_SESSION['pResult'] = '';
	}
?>
  <?php if($membre->testerStatue()){ ?>
      <div class="album py-5 bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

    <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Publications pour les élèves</text></svg>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="main.php?enc=pub&type=eleve"><button type="button" class="btn btn-sm btn-outline-secondary">Voir</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Publications pour les visiteurs</text></svg>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="main.php?enc=pub&type=visiteur"><button type="button" class="btn btn-sm btn-outline-secondary">Voir</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Publications pour les responsables</text></svg>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="main.php?enc=pub&type=administrateur"><button type="button" class="btn btn-sm btn-outline-secondary">Voir</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>

    </div>
    </div>
   </div>
<?php } ?>

	<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Ajout d'une publication</h1>
        <p class="col-lg-10 fs-4">Les publications permettent de vous communiquer avec les membres de l'Etablissement et les visiteurs du site, vous pouvez insérer toute sorte d'information pour inciter par exemple les visiteurs à s'inscrire. Entrer les informations correspondantes</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="modele/ajoutPub.php" enctype="multipart/form-data" method="POST">
          <div class="form-floating mb-3">
            <input type="text" name="titre" class="form-control" id="floatingInput" required placeholder="Mot">
            <label for="floatingInput">Titre</label>
          </div>
          <div class="form-floating mb-3">
          <span class="input-group-text">Contenue</span>
          <textarea class="form-control" aria-label="With textarea" name="contenue"></textarea>
        </div>
        <div class="mb-3">
          <input type="file" name="monfichier" class="form-control form-control-sm" aria-label="Small file input example" required>
        </div>
				 <div class="checkbox mb-3">
            <label>
              <input type="checkbox" name="visteur"> Visiteur
            </label>
          </div>
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" name="administrateur"> Administrateur
            </label>
          </div>
          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" name="Eleve"> Eleve
            </label>
          </div>

			<input type="hidden" name="auteur" value="<?=$membre->getAppelation()?>">
          <button class="w-100 btn btn-lg btn-primary" type="submit">Envoyer</button>
          <hr class="my-4">
          <small class="text-muted">En cliquant sur envoyer, vous acceptez les termes d'utilisation</small>
        </form>
      </div>
    </div>
  </div>
	<script type="text/javascript">
			var lien = document.getElementById("pub");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Annonce';
	include_once("vue/template2.php");