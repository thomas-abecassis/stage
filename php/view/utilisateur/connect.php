<div class="container">
  <div class="col s4 offset-s4">
      <div  class="creationCompteCard card">
        <h4 class="center">Connexion</h4>
         <form id="connexion" method="get" action="index.php">
              <p>
                <input value= "" type="text" placeholder="e-mail" name="login" id="immat_id" required />
              </p>
              <p>
                <input value= "" type="password" placeholder="mot de passe" name="mdp" id="mdp_id" required />
              </p>
              <p class="center">
                <input id="boutonConnexion" class="col s10 offset-s1  secondeCouleur" type="submit" value="Envoyer" />
              </p>
              <input type='hidden' name='action' value='connected'>
              <input type='hidden' name='controller' value='utilisateur'>
          </form>
        </div>
      </div>
     </div>
    <a href="index.php?action=create&controller=utilisateur">créér un compte<a>
