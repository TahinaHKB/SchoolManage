<?php
	$title = "Connexion";
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
	<body class="text-center">
<main class="form-signin">
  <form action="modele/ConnexionAdmin.php" method="POST">
    <img class="mb-4" src="image/adm/Default.png" alt="" width="72">
    <h1 class="h3 mb-3 fw-normal">Se connecter</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" name="appelation" placeholder="name@example.com">
      <label for="floatingInput">Appelation</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" name="mdp" placeholder="Password">
      <label for="floatingPassword">Mot de passe</label>
    </div>
    <div class="checkbox mb-3">
      <?php 
        if(isset($_SESSION['err']))
  {
    echo $_SESSION['err'];
    $_SESSION['err'] = "";
  }
      ?>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
  </form>
</main>  
  </body>
<?php
	$contenue = ob_get_clean();
	include_once("template.php");