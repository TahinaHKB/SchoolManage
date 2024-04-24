<?php
	$title = "Reinscription";
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
	$me = $membre->getMembre();
?>
	<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">PAYEMENT PAR MOBILE MONEY au (numero) </h1>
        <p class="col-lg-10 fs-4">Vous pouvez payer par mobile money, pour cela il faut envoyer l'argent puis nous envoyer la reférence (obtenue dans le message Mvola après l'envoye), puis le payement sera confirmé de notre côté</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="modele/payement.php" method="POST">
          <div class="form-floating mb-3">
            <input type="text" name="ref" class="form-control" id="floatingInput" required placeholder="Ref">
            <label for="floatingInput">Reference(ref)</label>
          </div>
          <div class="form-floating mb-3">
            <input name="num" type="text" class="form-control" id="floatingPassword" required placeholder="Nombre">
            <label for="floatingPassword">Numero d envoye</label>
          </div>
          <div class="form-floating mb-3">
            <input name="som" type="number" class="form-control" id="floatingPassword" required placeholder="Adresse">
            <label for="floatingPassword">Somme total</label>
          </div>
 			<input type="hidden" name="nom" value="<?=$me['Id']?>"></br>
		<input type="hidden" name="type" value="reinscription">
          <button class="w-100 btn btn-lg btn-primary" type="submit">Envoyer</button>
          <hr class="my-4">
          <small class="text-muted">En cliquant sur envoyer, vous acceptez les termes d'utilisations</small>
        </form>
      </div>
    </div>
  </div>
	<script type="text/javascript">
			var lien = document.getElementById("rein");
			lien.className = "nav-link active";
		</script>

<?php
	$contenue = ob_get_clean();
	$page = "Réinscription";
	include_once("vue/template2.php");