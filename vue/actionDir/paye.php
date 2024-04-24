<?php
	$title = "Re-inscription";
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
	?>
	<div class="bd-example">
        <table class="table table-hover">
          <thead>
          <tr>
            <th scope="col">Numero</th>
            <th scope="col">Reference</th>
            <th scope="col">Eleve</th>
            <th scope="col">Somme</th>
            <th scope="col">Type</th>
            <th scope="col">Nombre mois</th>
            <th scope="col">Action</th>
          </tr>
          </thead>
          <tbody>
	<?php
	$req = $bdd->query("SELECT * FROM payement");
	$paye = $req->fetchAll();
	foreach ($paye as $key => $value) {
			$rech = $bdd->prepare("SELECT * FROM eleve WHERE Id=:i");
			$rech->execute(array(
				"i" => $value['Eleve']
			));
			$perso = $rech->fetch();
		?>
		<tr>
			<th><?=$value['Numero']?></th>
			<td><?=$value['Reference']?></td>
			<td><?=$perso['Appelation']?></td>
			<td><?=$value['Somme']?></td>
			<td><?=$value['Type']?></td>
			<td><?php if($value['Nombre']>0){echo '  nombre de mois : '.$value['Nombre'];}?></td>
			<td>
			<?php 
				if($value['Type']=='reinscription')
				{
				?>
					<a href="main.php?t=re&id=<?=$value['Eleve']?>&perso=<?=$perso['Appelation']?>">Accepter</a>
				<?php
				}
				else
				{
				?>
					<a href="main.php?enc=eco&id=<?=$value['Eleve']?>&perso=<?=$perso['Appelation']?>">Accepter</a>
				<?php
				}
				?>
				</td>
		</tr>
		<?php
	}
?>
		</tbody>
	</table>
	</div>
<script type="text/javascript">
			var lien = document.getElementById("pay");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Payements reçu';
	include_once("vue/template2.php");