<?php
	$title = "Annee scolaire";
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
	$req = $bdd->query("SELECT * FROM examen WHERE Etat=1");
	$nb = $req->rowCount();
	if($nb==0)
	{
?>
	<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Demarrer un examen</h1>
        <p class="col-lg-10 fs-4">Démarrer un examen indique qu'un examen va avoir lieu</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="modele/ajoutExamen.php" method="POST">
          <div class="form-floating mb-3">
            <input type="text" name="appelation" class="form-control" id="floatingInput" required placeholder="Appelation">
            <label for="floatingInput">Nom</label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit">Envoyer</button>
          <hr class="my-4">
          <small class="text-muted">En cliquant sur envoyer, vous acceptezs les termes d'utilisation</small>
        </form>
      </div>
    </div>
  </div>
  <canvas class="my-4 w-100" id="myChart" width="900" height="50"></canvas>
	<ul>
<?php
	}
	?>
	<div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Date de début</th>
            <th scope="col">Date de fin</th>
            <th scope="col">Année scolaire</th>
          </tr>
          </thead>
          <tbody>
	<?php
		foreach ($donnees as $key => $value) {
			$req = $bdd->prepare("SELECT * FROM annee_scolaire WHERE Id=:i");
		$req->execute(array(
			"i" => $value['Scolaire']
		));
		$sco = $req->fetch();
		?><tr>
			<th><?= preg_replace("#_#", " ", $value['Nom'])?></th>
			<td><?=$value['DateDebut']?></td>
			<td>
					<?php
					if($value['Etat'])
					{
						echo ' Pas encore publié <a href="modele/desactiverExamen.php?id='.$value['Id'].'">Sortir les resultats</a>';
					} 
					else 
					{
						echo $value['DateFin'];
					}
				?>
			</td>
			<td><?=$sco['Nom']?></td>
			<?php
		}
	?>
		</tbody>
	</table>
	</div>
	<script type="text/javascript">
			var lien = document.getElementById("exa");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Examen';
	include_once("vue/template2.php");