<div class="container">
    <div  class="col s12 m10 l7 offset-m1 offset-l2 noPadding" id="retour">

 <a href="index"> <i class="material-icons">keyboard_backspace</i> <span class="absolute sousLignerHover">Aller à la recherche </span></a>

</div>
        <?php
        if($alertes != false){
            foreach ($alertes as $alerte){
                echo '  <div class="col s12 m10 l7 offset-m1 offset-l2 card boite">
                            <div class="idAlerte">'.htmlspecialchars($alerte->getId()).'</div>
                            <div class="infoBoite">
                            <div>
                			<div class="red-text text-darken-1 deleteAlerte legerGras"><i class=" material-icons small">delete_forever</i><span>supprimer la recherche</span> </div>
                			<div class="contientNom"><div class="nomAlerte">'.htmlspecialchars($alerte->getNom()).'</div>
                            <input class="modificationNom"  value="'.htmlspecialchars($alerte->getNom()).'" type="text" autocomplete="off" /></div>
                            <p class="grey-text grey-lighten-1">   <span >'.htmlspecialchars($alerte->getLocalisation()).", ".htmlspecialchars($alerte->getSurfaceStr()).", ".htmlspecialchars($alerte->getBudgetStr()) .' </span></p>
                              <div class="switch legerGras">
                                <label>';

                                  if($alerte->getActiveMail()){
                                        echo '<input checked type="checkbox">';
                                  }
                                  else{
                                    echo '<input type="checkbox">';
                                  }

                                  echo '<span class="lever noMargin"></span>

                                </label>
                                <span class="textAlerteMail">
                                    m\'alerter par mail
                                </span>
                              </div>
                            <div class="boutonsAlerte">
                                <a href="index/lotApprofondi/searchedDeepenAlerte/?page=1&alerte='.urlencode(serialize($alerte)).'"><div class="boutonAlerte boutonAnnonces secondeCouleur">Voir les lots</div></a>
                                <div class="boutonAlerte boutonModification secondeCouleurBorder"> Modifier</div></div>
                            </div>
                            </div>

            		    </div>';
            }
        }
        else{
            echo '
            <div class="col s12 m10 l7 offset-m1 offset-l2 ">  
              <div class="center">
                <p class="grandeTailleFont">Vous n\'avez pas encore enregistré de recherches  !</p>
                <p class=" grey-text "> Enregistrez vos recherches pour ne pas rater les nouvelles offres</p>
              </div>
            </div>';  
        }
        ?>
      </div>

        <script src="js/deleteAlerte.js" defer></script>
