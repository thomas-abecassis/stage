    <?php

    $controller=static::$object;
    ?>
    <div id="searchBox" class="card col s6 offset-s3">
      <div class="row">
        <h4 class="center">Connexion</h4>
        <div class="col s8 offset-s2  ">
         <form id="connexion" method="get" action="index.php">
              <p>
                <input value= "" type="text" placeholder="e-mail" name="login" id="immat_id" required />
              </p>
              <p>
                <input value= "" type="password" placeholder="mot de passe" name="mdp" id="mdp_id" required />
              </p>
              <p >
                <input id="boutonConnexion secondeCouleur" class="col s10 offset-s1" type="submit" value="Envoyer" />
              </p>
              <input type='hidden' name='action' value='connected'>
              <input type='hidden' name='controller' value='utilisateur'>
          </form>
        </div>
      </div>
    </div>
