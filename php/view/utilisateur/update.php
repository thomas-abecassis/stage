
  <div id="racine" class="col s4 offset-s4">
      <div  id="racineCard" class="creationCompteCard card">
        <i id="close" class="small grey-text absolute material-icons">close</i>
          <form   id="formConnexion" method=post action=index.php>
            <h4 class="center">creation de compte</h4>
            <div class="ligne"></div>
            <p>
              <input value=""  autocomplete="email" type="email"  placeholder="Votre mail" name="login" id="inputMail" required/>
            </p>
            <p>
              <input value = "" autocomplete="family-name" type="text" placeholder="Votre nom" name="nom" id="inputNom" required />
            </p>
            <p>
              <input value= "" autocomplete="given-name" type="text" placeholder="Votre prenom" name="prenom" id="inputPrenom" required/>
            </p>
            <p>
              <input value= "" autocomplete="new-password" type="password" placeholder="Mot de passe" name="mdp" id="inputMdp" required/>
            </p>
            <p>
              <input value= ""  autocomplete="new-password" type="password" placeholder="Confirmer votre mot de passe" name="confirmMdp" id="confirmMdp" required/>
            </p>
              <input type='hidden' name='controller' value='utilisateur'>
              <input type='hidden' name='action' value='created'>
            <p class="center">
              <input id="boutonConnexion" class="col s10 offset-s1  secondeCouleur" type="submit" value="Créer votre compte" />
            </p>
          </form>
    </div>
  </div>
