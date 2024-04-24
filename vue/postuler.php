<?php
	$title = "Postuler";
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
    <link href="style/signin.css" rel="stylesheet">
<?php
	$header = ob_get_clean();
	ob_start();
?>
	<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Postuler</h1>
        <p class="col-lg-10 fs-4">Vous pouvez nous detailler vos compétences et votre lettre de motivation ci-contre, ce formulaire est valable que ce soit pour ceux qui désirent travailler pour nous ou un future élève qui souhaite etudier dans notre etablissement. Envoyer-nous vos informations et nous vous répondrons par téléphone (si vous laissez votre numéro dans la lettre) ou par email.</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="#" enctype="multipart/form-data" method="POST">
          <div class="form-floating mb-3">
            <input type="mail" name="Email" class="form-control" id="floatingInput" required placeholder="Mot">
            <label for="floatingInput">Votre email</label>
          </div>
          <div class="form-floating mb-3">
          <span class="input-group-text">Contenue</span>
          <textarea class="form-control" aria-label="With textarea" name="txt"></textarea>
        </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Envoyer</button>
          <hr class="my-4">
          <small class="text-muted">En cliquant sur envoyer, vous acceptez les termes d'utilisation</small>
        </form>
      </div>
    </div>
  </div>
<?php
	$contenue = ob_get_clean();
	include_once("template.php");