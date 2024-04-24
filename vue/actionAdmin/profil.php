<?php
	$title = "Profil";
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
      #renums
      {
      	display: none;
      }
      #table
      {
      	width: 50%;
      	margin: 0 auto;
      	font-size: 10px;
      }
      .btn
      {
      	width: 70px;
      	height: 20px;
      	padding: 0;
      	font-size: 10px;
      }
      #pro
      {
      	width: 100%;
      	margin: 0 auto;
      	text-align: center;
      }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
        #table
      	{
      		font-size: 20px;
      	}
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="style/heroes.css" rel="stylesheet">
<?php
	$header = ob_get_clean();
	$req2 = $bdd->prepare("SELECT * FROM administrateur WHERE Id=:e");
	$req2->execute(array(
		"e" => $me['Id']
	));
	$prof = $req2->fetch();
	$appelation = preg_replace("#_#", " ", $prof['Appelation']);
	ob_start();
	if(isset($_SESSION['pResult']) && $_SESSION['pResult']<>'')
	{
		?>
		<p class="list-group-item list-group-item-action list-group-item-success"><?=$_SESSION['pResult']?></p>
		<?php
					$_SESSION['pResult'] = '';
	}
?>

    <div id="pro">
    	<form action="modele/mettreAjourDir.php" enctype="multipart/form-data" method="POST">
				<label for="renums"><img src="image/adm/<?= $prof['Photo'] ?>" width="100" loading="lazy"></label>
				<input type="file" name="monfichier" id="renums" required>
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
				<input type="hidden" name="type" value="photo"></br>
				<input type="submit" class="btn btn-primary" value="modifier">
			</form>
      <h1 class="display-4 fw-bold"><?=$appelation?></h1>
    </div>
<div class="bd-example">
        <table class="table table-hover" id="table">
          <tbody>
          <tr>
            <th scope="row">Votre poste : </th>
            <td>Admnistrateur</td>
          </tr>
          <tr>
          	<form method="POST" action="modele/mettreAjourDir.php">
				<th><label for="renum">Appelation :</label></th>
				<td><input type="text" name="renum" id="renum" value="<?= $prof['Appelation'] ?>">
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
				<input type="hidden" name="type" value="nom">
				<input type="submit" value="modifier"></td>
			</form>
          </tr>  
          <form method="POST" action="modele/mettreAjourDir.php">
          <tr>
				<th><label for="renum">Mot de passe :</label></th>
				<td><input type="password" name="mdp" id="renum" required></td>
		  </tr>
		  <tr>
				<th><label for="renum2">Nouveau mot de passe :</label></th>
				<td><input type="password" name="mdpNew" id="renum2" required>
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
				<input type="hidden" name="type" value="mdp">
				<input type="submit" value="modifier"></td>
		   </tr>
		  </form>
		  <tr>
		  	<th>Renumeration :</th>
		  	<td><?=$prof['Renumeration']?></td>
		  </tr>
		  <tr>
		  	<th>Adresse :</th>
		  	<td><?= $prof['Adresse'] ?></td>
		  </tr>
		  <tr>
		  	<form method="POST" action="modele/mettreAjourDir.php">
				<th><label for="renum">Numero de telephone :</label></th>
				<td><input type="number" name="renum" id="renum" value="<?= $prof['Numero'] ?>">
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
				<input type="hidden" name="type" value="num">
				<input type="submit" value="modifier"></td>
			</form>
		  </tr>
		  <tr>
		  	<form method="POST" action="modele/mettreAjourDir.php">
				<th><label for="renum">Email :</label></th>
				<td><input type="mail" name="renum" id="renum" value="<?= $prof['Email'] ?>">
				<input type="hidden" name="Id" value="<?=$prof['Id']?>">
				<input type="hidden" name="perso" value="<?=$prof['Appelation']?>">
				<input type="hidden" name="type" value="mail">
				<input type="submit" value="modifier"></td>
			</form>
		  </tr>
		  <tr>
		  	<th>Date d'embauche : </th>
		  	<td><?= $prof['DateDebut'] ?></td>
		  </tr>
          </tbody>
        </table>
        </div>
<?php
	$contenue = ob_get_clean();
	$page = "Profil";
	include_once("vue/template2.php");