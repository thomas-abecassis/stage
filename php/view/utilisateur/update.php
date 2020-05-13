
  <div id="racine" class="col s4 offset-s4">
      <div  id="racineCard" class="creationCompteCard card">
          <form id="formConnexion" method=post action=index.php>
            <h4 class="center">creation de compte</h4>
            <div class="ligne"></div>
            <p>
              <input type=email value=""  type="text" placeholder="Ex : 256AB34" name="login" id="inputMail" required/>
            </p>
            <p>
              <input value = "" type="text" placeholder="Ex : bleu" name="nom" id="inputNom" required />
            </p>
            <p>
              <input value= "" type="text" placeholder="Ex : Renault" name="prenom" id="inputPrenom" required/>
            </p>
            <p>
              <input value= "" type="password" placeholder="azerty123" name="mdp" id="inputMdp" required/>
            </p>
            <p>
              <input value= ""  type="password" placeholder="azerty123"  id="prenom_id" required/>
            </p>
              <input type='hidden' name='controller' value='utilisateur'>
              <input type='hidden' name='action' value='created'>
            <p class="center">
              <input id="boutonConnexion" class="col s10 offset-s1  secondeCouleur" type="submit" value="Créer votre compte" />
            </p>
          </form>
    </div>
  </div>
