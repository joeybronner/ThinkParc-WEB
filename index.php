<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
<meta charset="utf-8">
<title>Think Parc</title>
  <link rel="stylesheet" href="css/style3.css">

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="http://www.modernizr.com/downloads/modernizr-latest.js"></script>
<script type="text/javascript" src="placeholder.js"></script>
</head>
<body>

<br /><br /><br /><br /><br /><br /><br /><br /><br />
  <p align="center">
    <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "login")) { // Affiche l'erreur  ?>
	<br/>
   <center> <h2>Echec d'authentification - Login ou mot de passe incorrect</h2></center>
    <?php } 
    if(isset($_GET['erreur']) && ($_GET['erreur'] == "logout")) { // Affiche l'erreur 
    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}


session_destroy();

  } ?>
    <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "intru")) { // Affiche l'erreur ?>
    <center><strong>Echec d'authentification.. : Aucune session n'est ouverte ou vous n'avez pas les droits pour afficher cette page</strong></center>
    <?php } ?>
  </p>

  <section class="container">
    <div class="login">
      <h1>Please log in</h1>
<form action="accueil.php" method="post">
        <p><input type="text" name="login" placeholder="User ID"></p>
        <p><input type="password" name="pass" placeholder="Password"></p>

        <p class="submit"><center><input type="submit" name="commit" value="Login"></center></p>
</form>
    </div>
  </section>
<br /><br />
  <section class="about">
    <p class="about-links">
      <a href="Mythinkparc.html" target="_blank">My Think Parc</a>
      <a href="Qsn.html" target="_blank">Qui sommes-nous?</a>
    </p>
    <p class="about-author">
	  <center><a href="index.html" target="_blank"><img src="images/logo.png" style="width:130px; height:100px;></a></center>
      &copy; 2013&ndash;2014 <a href="FTC.html" target="_blank"></a> <br>
      Original PSD 
  </section>

</body>
</html>


