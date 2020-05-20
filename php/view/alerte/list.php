<div class="container">
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
                                    m\'alerter par mail
                              </div>
                            <div class="boutonsAlerte">
                                <a href="index/lotApprofondi/searchedDeepenAlerte/?alerte='.urlencode(serialize($alerte)).'"><div class="boutonAlerte boutonAnnonces secondeCouleur">Voir les lots</div></a>
                                <div class="boutonAlerte boutonModification secondeCouleurBorder"> Modifier</div></div>
                            </div>
                            </div>

            		    </div>';
            }
        }
        else{
            echo "aucune annonce ne correspond à votre recherche";
        }
        ?>
      </div>

        <script type="text/javascript" src="js/deleteAlerte.js"></script>
