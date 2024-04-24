<?php
	$title = "Ecollage";
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
	$rech = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");
	$value = $rech->fetch();
	$req = $bdd->prepare("SELECT * FROM ecollage WHERE Eleve=:e AND scolaire=:s");
		$req->execute(array(
			"e" => $membre->getAppelation(),
			"s" => $value['Id']
		));
		$ecollage = $req->fetchAll();
		$req = $bdd->query("SELECT * FROM mois");
		$mois = $req->fetchAll();
		$me = $membre->getMembre();
	$req = $bdd->prepare("SELECT * FROM payement WHERE Eleve=:e AND Type=:t");
		$req->execute(array(
			"e" => $me['Id'],
			"t" => 'ecollage'
		));
		$attente = $req->fetchAll();
	?>
	<div class="album py-5 bg-light">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-md-4 g-4">
      	 <?php
  foreach ($attente as $key => $m) {
				?>
				<div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em"><?=$m['Numero']?></br></text></svg>
            <div class="card-body">
            	<p class="card-text"><?= 'num : '.$m['Reference'].' envoyé : '.$m['Somme'].'Ar' ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Attente</small>
              </div>
            </div>
          </div>
        </div>
				<?php
			}
?>

        <?php
  foreach ($mois as $key => $m) {
    $in = false;
			foreach($ecollage as $key => $e)
			{
				if($m['Id']==$e['Mois'])
				{
					$in = true;
				}
			}
			if($in)
			{
				?>
				<div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em"><?=$m['Nom']?></text></svg>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Payé</small>
              </div>
            </div>
          </div>
        </div>
				<?php
			}
  }
?>
    </div>
    </div>
   </div>
	<?php
		$me = $membre->getMembre();
?>
	<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Payer votre ecollage en ligne</h1>
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
          <div class="form-floating mb-3">
            <input name="nb" type="text" class="form-control" id="floatingPassword" required placeholder="Adresse">
            <label for="floatingPassword">Nombre de mois</label>
          </div>
 			<input type="hidden" name="nom" value="<?=$me['Id']?>"></br>
		<input type="hidden" name="type" value="ecollage">
          <button class="w-100 btn btn-lg btn-primary" type="submit">Envoyer</button>
          <hr class="my-4">
          <small class="text-muted">En cliquant sur envoyer, le professeur accepte les termes d'utilisation</small>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript">
			var lien = document.getElementById("eco");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Ecollage>'.$value['Nom'];
	include_once("vue/template2.php");