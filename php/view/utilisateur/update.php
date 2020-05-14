
  <div id="racine" class="col s4 offset-s4">
      <div  id="racineCard" class="creationCompteCard card">
          <form id="formConnexion" method=post action=index.php>
            <h4 class="center">creation de compte</h4>
            <div class="ligne"></div>
            <p>
              <input type=email value=""  type="text" placeholder="Votre mail" name="login" id="inputMail" required/>
            </p>
            <p>
              <input value = "" type="text" placeholder="Votre nom" name="nom" id="inputNom" required />
            </p>
            <p>
              <input value= "" type="text" placeholder="Votre prenom" name="prenom" id="inputPrenom" required/>
            </p>
            <p>
              <input value= "" type="password" placeholder="Mot de passe" name="mdp" id="inputMdp" required/>
            </p>
            <p>
              <input value= ""  type="password" placeholder="Confirmer votre mot de passe"  id="prenom_id" required/>
            </p>
              <input type='hidden' name='controller' value='utilisateur'>
              <input type='hidden' name='action' value='created'>
            <p class="center">
              <input id="boutonConnexion" class="col s10 offset-s1  secondeCouleur" type="submit" value="Créer votre compte" />
            </p>
          </form>
    </div>
  </div>
