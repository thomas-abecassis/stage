<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <title><?php echo $pagetitle; ?></title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/alerte.css">
  <link rel="stylesheet" type="text/css" href="css/animation.css">
    <link rel="stylesheet" type="text/css" href="css/couleur.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
   <!-- Social media Font -->
  <link rel="stylesheet" href="https://d1azc1qln24ryf.cloudfront.net/114779/Socicon/style-cf.css?9ukd8d">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">




</head>

<body class=" grey lighten-3">
        <header>
        	 <nav   id="menu" class="nav-wraper premiereCouleur">
               <!-- <img href="#index.html" id="logo" src="https://www.logolynx.com/images/logolynx/0a/0a541bcbcef40a7c1058c0d02db88762.png"alt="Le logo."> -->
                <ul id="nav-mobile" class="right hide-on-med-and-down">

                		<li><a href="index.php">Accueil</a></li>
                        <li ><a href="index.php?action=readAll">Produits</a></li>
                		<li ><a href=" index.php?action=readAll&controller=utilisateur">Utilisateurs</a></li>

                        <?php
                        if(isset($_SESSION["login"])){
                            echo "<li><a href=\"index.php?action=read&controller=alerte\">Mes recherches</a></li>";
                            echo "<li><a id=\"deconnexion\">Deconnexion</a></li>";
                        }else{
                           echo "<li><a id=\"creationCompte\">Créer un compte</a></li>";
                           echo "<li><a id=\"connexion\">Se connecter</a></li>";
                        }
                        ?>

            	</nav>

        </header>
        <main><?php
        if(Session::is_admin()) {  
         echo '<div class="colorPicker card">
            <h6>Modifier les couleur</h6>
            <div class="ligne"></div>
              <button id="colorPicker1">couleur principale</button>
              <button id="colorPicker2">couleur secondaire </button>
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


    </div>
  </main>

    <div class="pad1">
        <footer >
        <!-- Footer social -->
          <section class="ft-social">
            <ul class="ft-social-list">
              <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-facebook grey-text text-darken-1"></span></a></li>
              <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-twitter grey-text text-darken-1"></span></a></li>
              <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-linkedin grey-text text-darken-1"></span></a></li>
              <li><a href="#" class="pure-button button-socicon"><span class="socicon socicon-instagram grey-text text-darken-1"></span></a></li>
            </ul>
          </section>

          <!-- Footer legal -->
          <section class="ft-legal">
            <ul class="ft-legal-list">
              <li><a href="#">Termes &amp; Conditions</a></li>
              <li><a href="#">Mentions légales &amp; CGU</a></li>
              <li><a href="#">Données personnelles</a></li>
              <li>&copy; 2019 Copyright Sofuto Inc.</li>
            </ul>
          </section>

        </footer>
    </div>


</body>
<script type="text/javascript" src="js/lib/colorPicker.js"></script>
<script type="text/javascript" src="js/sauvegarde.js"></script>
<script type="text/javascript" src="js/changerCouleur.js"></script>

</html>
