<?php
	$title = "Direction";
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
    $appelation = preg_replace("#_#", " ", $value['Appelation']);
?>
    <div class="col">
          <div class="card shadow-sm">
            <img src="image/adm/<?= $value['Photo'] ?>" width="100%">
            <div class="card-body">
              <p class="card-text"><?= $appelation ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="main.php?id=<?=$value['Id']?>&perso=<?=$value['Appelation']?>&t=dr"><button type="button" class="btn btn-sm btn-outline-secondary">Voir</button></a>
                </div>
                <small class="text-muted"><?=$value['DateDebut']?></small>
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
        <h1 class="display-4 fw-bold lh-1 mb-3">Ajouter un nouveau membre de la direction</h1>
        <p class="col-lg-10 fs-4">Un membre de la direction a plusieurs tâche à accomplir, il aide dans la gestion de l'établissement. Entrer ses informations correspondants</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="modele/ajoutDirection.php" method="POST">
          <div class="form-floating mb-3">
            <input type="text" name="appelation" class="form-control" id="floatingInput" required placeholder="Appelation">
            <label for="floatingInput">Nom et prénoms</label>
          </div>
          <div class="form-floating mb-3">
            <input name="renum" type="number" class="form-control" id="floatingPassword" required placeholder="Nombre">
            <label for="floatingPassword">Renumération</label>
          </div>
          <div class="form-floating mb-3">
            <input name="adresse" type="text" class="form-control" id="floatingPassword" required placeholder="Adresse">
            <label for="floatingPassword">Adresse</label>
          </div>
          <div class="form-floating mb-3">
            <input name="num" type="number" class="form-control" id="floatingPassword" required placeholder="Numero">
            <label for="floatingPassword">Numero</label>
          </div>
          <div class="form-floating mb-3">
            <input name="email" type="mail" class="form-control" id="floatingPassword" required placeholder="exemple@gmail.com">
            <label for="floatingPassword">Email</label>
          </div>
          <div class="form-floating mb-3">
            <input name="mdp" type="password" class="form-control" id="floatingPassword" required placeholder="exemple@site.com">
            <label for="floatingPassword">Mot de passe</label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Envoyer</button>
          <hr class="my-4">
          <small class="text-muted">En cliquant sur envoyer, le future administrateur accepte les termes d'utilisation</small>
        </form>
      </div>
    </div>
  </div>
   <script type="text/javascript">
			var lien = document.getElementById("dir");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Administration';
	include_once("vue/template2.php");