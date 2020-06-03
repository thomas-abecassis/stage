<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title><?php echo $pagetitle; ?></title>
  <base href='http://localhost/stage/'>
  <link rel="shortcut icon" href="image/favicon.png" />
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/couleur.css">
  <link rel="stylesheet" type="text/css" href="css/socicon/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js" defer></script>
  <script src="js/lib/colorPicker.js" defer></script>
  <script src="js/script.js" defer></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">




</head>

<body class=" grey lighten-3">
        <header>
        	 <nav   id="menu" class="nav-wraper premiereCouleur">
               <a href="index">
                <?php
                date_default_timezone_set('Europe/Paris');
                $date = date_create();
                $timestamp = date_timestamp_get($date);
                echo '<img id="logo" src="image/logo.png?t=' . $timestamp . '" alt="Le logo.">';
                ?>
              </a>
    <ul id="slide-out" class="sidenav grey-text text-darken-2">
    <li><a href="#!">acceuil</a></li>
    <li><div class="divider"></div></li>
    <?php
    if(isset($_SESSION["login"])){
    echo '<li><a href="index/alerte/read/">Mes recherches</a></li>
          <li><div class="divider"></div></li>
          <li><a class="subheader grey-text">Mon compte</a></li>
          <li><a href="index/utilisateur/Read/?id='.rawurlencode($_SESSION["login"]).'" >Paramètres</a></li>
          <li><a id="deconnexion1">Déconnexion</a></li>';
    }
    else{
      echo "<li><a id=\"creationCompte1\">Créer un compte</a></li>";
      echo "<li><a id=\"connexion1\">Se connecter</a></li>";
    }
    if(Session::is_admin()){

      echo '<li><div class="divider"></div></li>
            <li><a href="index/utilisateur/readAll/">Utilisateurs</a></li>';
    }
    ?>
  </ul>
  <a id="burgerWrapper" href="#" data-target="slide-out" class="absolute sidenav-trigger"><i id="burger" class="absolute medium material-icons">menu</i></a>
                <ul id="nav-mobile" class="right ">
                		<li><a href="index">Accueil</a></li>
                        <?php
                        if(Session::is_admin()){
                          echo '<li ><a href=" index/utilisateur/readAll/">Utilisateurs</a></li>';
                        }
                        if(isset($_SESSION["login"])){
                            echo "<li><a href=\"index/alerte/read/\">Mes recherches</a></li>";
                            echo '<li><a class="dropdown-trigger" href="#" data-target="dropdown1">Mon compte</a></li>

                          <!-- Dropdown Structure -->
                          <ul id="dropdown1" class="dropdown-content">
                            <li><a href="index/utilisateur/Read/?id='.rawurlencode($_SESSION["login"]).'" >Paramètres</a></li>
                            <li><a id="deconnexion2">Déconnexion</a></li>
                          </ul>';
                        }else{
                           echo "<li><a id=\"creationCompte2\">Créer un compte</a></li>";
                           echo "<li><a id=\"connexion2\">Se connecter</a></li>";
                        }
                        ?>
                 </ul>
            	</nav>

        </header>
        <main>
          <div id="premiereCouleur" class="premiereCouleurText displayNone"></div>
          <div id="secondeCouleur" class="secondeCouleurText displayNone"></div>
            <div class="row">
            <?php
            $filepath = File::build_path(array("view", $controller, "$view.php"));

            require $filepath;
            ?>
            </div>

             <div class="container"> 
              <div class="row">
          <?php
        if(Session::is_admin()) {  
         echo '<div class="colorPicker card">
            <h6 class="center" >Modifier l\'apparence du site</h6>
            <div class="ligne"></div>
            <h6 class="center">Modifier le logo</h6> 
            <form id="formLogo">
              <input class="displayBlock" type="file" id="inputPhotoLogo" name="inputPhoto" >
              <input class="displayBlock" type="submit">
            </form>
            <div class="ligne"></div>
            <h6 class="center">Modifier la bannière</h6> 
            <form id="formBanniere">
              <input class="displayBlock" type="file" id="inputPhotoBanniere" name="inputPhoto" >
              <input class="displayBlock" type="submit">
            </form>
            <div class="ligne"></div>

            <h6 class="center">Modifier les couleurs</h6>
              
              <button class="displayBlock" id="colorPicker1">couleur principale</button>
              <button class="displayBlock" id="colorPicker2">couleur secondaire </button>
              <div class="ligne"></div>
          </div>';
        }
          ?>
            </div>
        </div>

  </main>

    <div class="pad1">
        <footer >
        <!-- Footer social -->
          <div class=" ft-social">
            <div class="ligne"></div>
              <div class="container">
                <div class="row">
                  <div class="col s6 m3 push-m2">
                    <h5 class="white-text">Contactez nous </h5>
                    <p class="grey-text text-lighten-4">Par téléphone : XX XX XX XX XX</p>
                    <p class="grey-text text-lighten-4">Par mail : toast@gmail.com</p>
                  </div>
                  <div class="col s6 m3 push-m4">
                    <h5 class="white-text">Retrouvez nous sur </h5>
                 <ul class="ft-social-list">
                  <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-facebook"></span></a></li>
                  <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-twitter"></span></a></li>
                  <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-linkedin"></span></a></li>
                  <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-instagram"></span></a></li>
                </ul>
              </div>
            </div>
          </div>
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
