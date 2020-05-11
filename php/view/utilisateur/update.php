
    <form method=post action=index.php>
      <div class="card">
          <legend>Mon formulaire :</legend>
          <p>
            <label for="immat_id">Email</label> :
            <input type=email value=""  type="text" placeholder="Ex : 256AB34" name="login" id="immat_id" required/>
          </p>

          <p>
            <label for="Nom_id">Nom</label> :
            <input value = "" type="text" placeholder="Ex : bleu" name="nom" id="Nom_id" required />
          </p>

          <p>
            <label for="prix_id">prenom</label> : 
            <input value= "" type="text" placeholder="Ex : Renault" name="prenom" id="prenom_id" required/>
          </p>
          <p>
            <label for="mdp_id">Mot de passe</label> :
            <input value= "" type="password" placeholder="azerty123" name="mdp" id="mdp_id" required/>
          </p>
          <p>
            <label for="mdp_id">confirmez votre mot de passe</label> :
            <input value= ""  type="password" placeholder="azerty123"  id="prenom_id" required/>
          </p>
            <input type='hidden' name='controller' value='utilisateur'>
            <input type='hidden' name='action' value='created'>
          <p>
            <input type="submit" value="Envoyer" />
          </p>
        </div>
      </form>


