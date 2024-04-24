<?php
	$title = "Professeur";
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
	if(isset($_SESSION['pResult']) && $_SESSION['pResult']<>'')
	{
		?>
		<p class="list-group-item list-group-item-action list-group-item-success"><?=$_SESSION['pResult']?></p>
		<?php
					$_SESSION['pResult'] = '';
	}
?>
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 row-cols-md-5 g-5">
        <?php
  foreach ($donnees as $key => $value) {
?>
    <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em"><?= $value['Nom'] ?></text></svg>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="main.php?id=<?=$value['Id']?>&perso=<?=$value['Nom']?>&t=mat"><button type="button" class="btn btn-sm btn-outline-secondary">Voir</button></a>
                </div>
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
	<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Ajout d'une matière</h1>
        <p class="col-lg-10 fs-4">La matière sera l'objet d'étude des élèves, chaque classe correspondra à plusieurs matières. Entrer les informations correspondantes</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="modele/ajoutMatiere.php" method="POST">
          <div class="form-floating mb-3">
            <input type="text" name="nom" class="form-control" id="floatingInput" required placeholder="Matière">
            <label for="floatingInput">Nom de la matiere</label>
          </div>
          <?php
			foreach($classe as $key => $value)
			{
		?>
				 <div class="checkbox mb-3">
            <label>
              <input type="checkbox" name="<?=$value['Nom'].$value['Identifiant']?>" value="remember-me"> <?=$value['Nom'].$value['Identifiant']?>
            </label>
          </div>
		<?php 
			}
		?>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Envoyer</button>
          <hr class="my-4">
          <small class="text-muted">En cliquant sur envoyer, vous acceptez les termes d'utilisation</small>
        </form>
      </div>
    </div>
  </div>
	<script type="text/javascript">
			var lien = document.getElementById("mat");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Matière';
	include_once("vue/template2.php");