<div class="container">
  <div class="col s4 offset-s4">
      <div  class="creationCompteCard card">
          <form id="connexion" method=post action=index.php>
            <h4 class="center">creation de compte</h4>
            <p>
              <input type=email value=""  type="text" placeholder="Ex : 256AB34" name="login" id="immat_id" required/>
            </p>
            <p>
              <input value = "" type="text" placeholder="Ex : bleu" name="nom" id="Nom_id" required />
            </p>
            <p>
              <input value= "" type="text" placeholder="Ex : Renault" name="prenom" id="prenom_id" required/>
            </p>
            <p>
              <input value= "" type="password" placeholder="azerty123" name="mdp" id="mdp_id" required/>
            </p>
            <p>
              <input value= ""  type="password" placeholder="azerty123"  id="prenom_id" required/>
            </p>
              <input type='hidden' name='controller' value='utilisateur'>
              <input type='hidden' name='action' value='created'>
            <p>
              <input id="boutonConnexion" class="col s10 offset-s1  secondeCouleur" type="submit" value="Envoyer" />
            </p>
          </form>
      </div>
    </div>
  </div>
