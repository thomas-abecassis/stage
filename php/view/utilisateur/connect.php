
  <div id="racine" class="col s4 offset-s4">
      <div  id="racineCard" class="creationCompteCard card">
        <i id="close" class="small grey-text absolute material-icons">close</i>
        <h4 class="center">Connexion</h4>
        <div class="ligne"></div>
         <form id="formConnexion" method="get" action="index.php">
              <!--<form id="connexion">-->
              <p>
                <input value= "" autocomplete="email" type="text" placeholder="e-mail" name="login" id="inputMail" required />
              </p>
              <p>
                <input value= "" autocomplete="current-password" type="password" placeholder="mot de passe" name="mdp" id="inputMdp" required />
              </p>
              <p class="center">
                <input id="boutonConnexion" class="col s10 offset-s1  secondeCouleur" type="submit" value="se connecter" />
              </p>
              <!--<input type='hidden' name='action' value='connected'> page classique -->
              <!--<input type='hidden' name='controller' value='utilisateur'> page classique -->
          </form>
          <div class="ligne"></div>
          <p class="center">
          Pas de compte ? Créez en un <a id="boutonRedirectCreation" class="sousLigner pointer" >ici</a>.
          </p>
        </div>
      </div>
    <!--<a href="index.php?action=create&controller=utilisateur">créér un compte<a> page classique -->
    <a id="boutonConnexion"  >créér un compte<a>
