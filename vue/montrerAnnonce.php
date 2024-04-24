<?php
	if(isset($_GET['id']))
	{
		$req = $bdd->prepare("DELETE FROM publications WHERE Id=:i");
	$req->execute(array(
		"i" => $_GET['id']
	));
	}
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
	ob_start();
	echo '<h1>Publications pour les '.$_GET['type'].'</h1>';
	$req = $bdd->prepare("SELECT * FROM publications WHERE Audiance=:a ORDER BY Id DESC");
	$req->execute(array(
		"a" => $_GET['type']
	));
	$data = $req->fetchAll();
	foreach ($data as $key => $value) {
	?>
	<div class="px-4 pt-5 my-5 text-center border-bottom">
    <h1 class="display-4 fw-bold"><?=$value['Auteur'].' : '.$value['Titre']?></h1>
    <div class="col-lg-6 mx-auto">
      <p><?=$value['Contenu']?></p>
    </div>
    <div class="overflow-hidden" style="max-height: 30vh;">
      <div class="container px-5">
      	<?php if($value['Image']<>''){?><img src="image/pub/<?=$value['Image']?>" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy"><?php } ?>
      </div>
    </div>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
        <i><?=$value['Dates']?></i>
      </div>
  </div>
<?php } ?>
<script type="text/javascript">
			var lien = document.getElementById("pub");
			lien.className = "nav-link active";
		</script>
<?php
	$contenue = ob_get_clean();
	$page = 'Publications > '.$_GET['type'];
	include_once("template2.php");