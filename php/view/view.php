<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="utf-8">
  <title><?php echo $pagetitle; ?></title>
  <base href='http://localhost/stage/'>
  <link rel="shortcut icon" href="image/favicon.png" />
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/alerte.css">
  <link rel="stylesheet" type="text/css" href="css/animation.css">
  <link rel="stylesheet" type="text/css" href="css/couleur.css">
  <link rel="stylesheet" type="text/css" href="css/socicon/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" defer></script>
  <script src="js/util.js" defer></script>
  <script src="js/lib/colorPicker.js" defer></script>
  <script src="js/sauvegarde.js" defer></script>
  <script src="js/changerCouleur.js" defer></script>
  <script src="js/sauvegardePhoto.js" defer></script>
  <script src="js/initialize.js" defer></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <script>
    window.MSInputMethodContext && document.documentMode && document.write('<script src="js/lib/ie11CustomProperties.js"><\x2fscript>');
  </script>




</head>

<body class=" grey lighten-3">
        <header>
        	 <nav   id="menu" class="nav-wraper premiereCouleur">
               <a href="index">
                <img id="logo" src="image/logo.png" alt="Le logo.">
              </a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">

                		<li><a href="index">Accueil</a></li>

                        <?php
                        if(Session::is_admin()){
                          echo '<li ><a href=" index/utilisateur/readAll/">Utilisateurs</a></li>';
                        }
                        if(isset($_SESSION["login"])){
                            echo "<li><a href=\"index/alerte/read/\">Mes recherches</a></li>";
                            echo  '<li><a class="dropdown-trigger" href="#" data-target="dropdown1">Mon compte</a></li>

                          <!-- Dropdown Structure -->
                          <ul id="dropdown1" class="dropdown-content">
                            <li><a href="index/utilisateur/Read/?id='.rawurlencode($_SESSION["login"]).'" >Paramètres</a></li>
                            <li><a id="deconnexion">Déconnexion</a></li>
                          </ul>';
                        }else{
                           echo "<li><a id=\"creationCompte\">Créer un compte</a></li>";
                           echo "<li><a id=\"connexion\">Se connecter</a></li>";
                        }
                        ?>
                 </ul>
            	</nav>

        </header>
        <main><?php
        if(Session::is_admin()) {  
         echo '<div class="colorPicker card">
            <h6 class="center" >Modifier l\'apparence du site</h6>
            <div class="ligne"></div>
            <h6 class="center">Modifier le logo</h6> 
            <form id="form">
            <input class="displayBlock" type="file" id="inputPhoto" name="inputPhoto" >
            </form>
            <div class="ligne"></div>

            <h6 class="center">Modifier les couleur</h6>
              
              <button class="displayBlock" id="colorPicker1">couleur principale</button>
              <button class="displayBlock" id="colorPicker2">couleur secondaire </button>
              <div class="ligne"></div>
          </div>';
        }
          ?>
            <div class="row">
            <?php
            $filepath = File::build_path(array("view", $controller, "$view.php"));

            require $filepath;
            ?>
            </div>


<?php /*
if(isset($_SESSION["panier"])){
    echo "<br>-----------------------panier--------------------<br>";
    $prix=0;
    foreach ($_SESSION["panier"] as $value) {
        echo $value->getNom()."<br>";
        $prix+=$value->getPrix();
    }
    echo strval($prix)."€";
    if(isset($_SESSION["login"])){
      echo '<a href=index.php?controller=commande&action=created>commander</a>';
    }
    echo "<br>-----------------------panier--------------------<br>";
} */
?>

  </main>

    <div class="pad1">
        <footer >
        <!-- Footer social -->
          <div class="ft-social">
            <ul class="ft-social-list">
              <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-facebook grey-text text-darken-1"></span></a></li>
              <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-twitter grey-text text-darken-1"></span></a></li>
              <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-linkedin grey-text text-darken-1"></span></a></li>
              <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-instagram grey-text text-darken-1"></span></a></li>
            </ul>
          </div>

          <!-- Footer legal -->
          <div class="ft-legal">
            <ul class="ft-legal-list">
              <li><a href="#">Termes &amp; Conditions</a></li>
              <li><a href="#">Mentions légales &amp; CGU</a></li>
              <li><a href="#">Données personnelles</a></li>
              <li>&copy; 2019 Copyright Sofuto Inc.</li>
            </ul>
          </div>

        </footer>
    </div>


</body>
</html>
