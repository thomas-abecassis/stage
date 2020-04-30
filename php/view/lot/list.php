
        <?php
        if($tab_v != false){
            foreach ($tab_v as $v)
                echo '  <a href=index.php?action=Read&id='.rawurlencode($v->getId()).'>
                        <div class="col s12 m10 l7 offset-m1 offset-l2 card boite boite_hover">
                            <div class="imageBoite" ><img src="../image/'.$v->getId().'/1.jpg"></div> 
                            <div class="infoBoite">
                			<p class="">' . htmlspecialchars($v->getnom()) . ' </p>
                			<p class="prix">'.htmlspecialchars($v->getLoyer()).' €/mois </p> 
                            <p class="surface">   <i class="material-icons">home</i><span class="surfaceText">'.htmlspecialchars($v->getSurface()) . 'm² </span></p>
                            <p class="surface">   <i class="material-icons">place</i><span class="surfaceText">'.htmlspecialchars($v->getLocalisation()) .' </span></p>
                            </div>
            		    </div>
                        </a>';   
        }
        else{
            echo "aucune annonce ne correspond à votre recherche";
        }?>
        <div id="sauvegardeAnnonce" class="col s12 m10 l7 offset-m1 offset-l2 card boite boite_hover">  <p id="inSauvegarde" class="flex"><i class="iconeNotif material-icons">notifications</i>Sauvegarder la recherche</p></div>
        <script>
        <?php 
            if(isset($_SESSION["login"])){
                echo "connecte = true";
            }
            else{
                echo "connecte = false";
            };
        ?></script>
        <script type="text/javascript" src="../js/sauvegarde.js"></script>


       