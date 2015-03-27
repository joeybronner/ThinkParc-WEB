  <!DOCTYPE html>
  <?php
  session_start();
  ?>
  <html>
  <head>
    <meta charset="utf-8">
    <title>Think Parc Software</title>
    <link rel="stylesheet" href="css/style3.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="http://www.modernizr.com/downloads/modernizr-latest.js"></script>
  </head>
  <body>
  <div class="bodylogin">
    <p>
      <?php if(isset($_GET['erreur']) && ($_GET['erreur'] == "login")) { // Affiche l'erreur  ?>
  	<br/>
     <h2>Echec d'authentification - Login ou de passe incorrect</h2>
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
      <strong>Echec d'authentification.. : Aucune session n'est ouverte ou vous n'avez pas les droits pour afficher cette page</strong>
      <?php } ?>
    </p>

    <section class="container">
      <div class="login">
        <h1>Think Parc Software</h1>
        <form action="web/accueil.php" method="post">
                <p><input type="text" name="login" placeholder="Identifiant"></p>
                <p><input type="password" name="pass" placeholder="Mot de passe"></p>
                <p class="submit">
                  <center><input type="submit" name="commit" value="Se connecter"></center>
                </p>
        </form>
      </div>
    </section>
  </div>
  </body>
  </html>


