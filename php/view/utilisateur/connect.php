<div class="container">
  <div class="col s4 offset-s4">
      <div  class="creationCompteCard card">
        <h4 class="center">Connexion</h4>
         <form id="formConnexion" method="get" action="index.php">
              <!--<form id="connexion">-->
              <p>
                <input value= "" type="text" placeholder="e-mail" name="login" id="inputMail" required />
              </p>
              <p>
                <input value= "" type="password" placeholder="mot de passe" name="mdp" id="inputMdp" required />
              </p>
              <p class="center">
                <input id="boutonConnexion" class="col s10 offset-s1  secondeCouleur" type="submit" value="Envoyer" />
              </p>
              <!--<input type='hidden' name='action' value='connected'> page classique -->
              <!--<input type='hidden' name='controller' value='utilisateur'> page classique -->
          </form>
        </div>
      </div>
     </div>
    <!--<a href="index.php?action=create&controller=utilisateur">créér un compte<a> page classique -->
    <a id="boutonConnexion"  >créér un compte<a>
