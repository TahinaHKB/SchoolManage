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
	$req = $bdd->query("SELECT * FROM annee_scolaire WHERE Etat=1");
	$nb = $req->rowCount();
	if($nb==0)
	{
?>
	<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">Demarrer une annee scolaire</h1>
        <p class="col-lg-10 fs-4">Démarrer une nouvelle année scolaire est une tâche à ne pas oublier, il faut impérativement en créer un en cours pour permettre les inscriptions et les réinscrpitions. Donner bien un nom à l'année scolaire, ils vous permettent de vous situer dans les années scolaire successives.</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <form class="p-4 p-md-5 border rounded-3 bg-light" action="modele/ajoutScolaire.php" method="POST">
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
<?php
	}
?>
<canvas class="my-4 w-100" id="myChart" width="900" height="50"></canvas>
        <div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Date de début</th>
            <th scope="col">Date de fin</th>
          </tr>
          </thead>
          <tbody>
	<?php
		foreach ($donnees as $key => $value) {
		?><tr>
			<th><?= $value['Nom']?></th>
			<td><?=$value['DateDebut']?></td>
				<?php
					if($value['Etat'])
					{
			$req = $bdd->query("SELECT * FROM examen WHERE Etat=1");
			$exa = $req->rowCount();
			if($exa==1)
			{
				echo '<td>En cours</td>';
			}
			else 
			{
				echo '<td>En cours <a href="modele/desactiverScolaire.php?id='.$value['Id'].'">Mettre fin</a></td>';
			}
					} 
					else 
					{
						echo '<td>'.$value['DateFin'].'</td>';
					}
		}
	?>
		</tbody>
	</table>
	</div>
	<script type="text/javascript">
			var lien = document.getElementById("sco");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Les années scolaire';
	include_once("vue/template2.php");