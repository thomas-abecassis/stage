<div class="container">
        <?php
        if($tab_v != false){
            foreach ($tab_v as $v){
                $filecount = 0;
                $files = glob("image/".htmlspecialchars($v->getId())."/*.*");
                if ($files){
                 $filecount = count($files);
                }
                echo '  <a href=index.php?controller=lotApprofondi&action=Read&id='.rawurlencode($v->getId()).$getURL."page=".$page.'>
                        <div class="col s12 m10 l7 offset-m1 offset-l2 card boite boite_hover">';
                        if($filecount!=0){
                          echo '<div class="imageBoite" ><img src="image/'.$v->getId().'/1.jpg"></div>';
                        }
                        else{
                          echo '<div class="imageBoite" ><img src="image/noPhoto.png"></div>';
                        }

                echo '<div class="infoBoite">
                			<p class="">' . htmlspecialchars($v->getnom()) . ' </p>
                			<p class="prix">'.htmlspecialchars($v->getLoyer()).' €/mois </p>
                            <p class="surface">   <i class="material-icons">home</i><span class="surfaceText">'.htmlspecialchars($v->getSurface()) . 'm² </span></p>
                            <p class="surface">   <i class="material-icons">place</i><span class="surfaceText">'.htmlspecialchars($v->getLocalisation()) .' </span></p>
                            </div>
            		    </div>
                        </a>';
            }
        }
        else{
            echo '
            <div class="col s12 m10 l7 offset-m1 offset-l2 ">  
              aucune annonce ne correspond à votre recherche 
            </div>';
        }?>
        <div id="sauvegardeAnnonce" class="col s12 m10 l7 offset-m1 offset-l2 card boite boite_hover secondeCouleur">  <p id="inSauvegarde" class="flex"><i class="iconeNotif material-icons">notifications</i>Sauvegarder la recherche</p></div>
        <div class="col s12 m10 l7 offset-m1 offset-l2">
        <ul class="center listeFinDePage">
        <?php
            if($page<=1){
            echo "<li><a><i class=\" grey-text text-lighten-1 material-icons\">chevron_left</i><span class=\"surfaceText\"></a></li>";
            }
            else{
              if(strcmp($lot, "lot")==0){
                echo "<li><a  href=\"index/lot/searched/?page=" . ($page-1) . $getURL . "\"> <i class=\"material-icons\">chevron_left</i><span class=\"surfaceText\"> </a></li>";
              }
              else{
                echo "<li><a  href=\"index/lotApprofondi/searchedDeepen/?page=" . ($page-1) . $getURL. "\"> <i class=\"material-icons\">chevron_left</i><span class=\"surfaceText\"> </a></li>";
              }
            }
            if($nbPage-$page>3){
              $i=$page-3;
            }else{
              $i=$page-6+($nbPage-$page);
            }
            $pageMax=$page+3;
            while($i<=$pageMax && $i<=$nbPage){
              if($i<1){
                $pageMax++;
              }
              else{
                if($i==$page){
                  if(strcmp($lot, "lot")==0){
                    echo "<li class=\"pageSelection\"><a href=\"index/lot/searched/?page=" . $i . $getURL ."\">" . $i . "</a></li>";
                  }
                  else{
                    echo "<li class=\"pageSelection\"><a href=\"index/lotApprofondi/?searchedDeepen&page=" . $i . $getURL ."\">" . $i . "</a></li>";
                  }
                }
                else{
                  if(strcmp($lot, "lot")==0){
                    echo "<li><a  href=\"index/lotApprofondi/searchedDeepen/?page=" . $i .$getURL . "\">" . $i . "</a></li>";
                  }
                  else{
                    echo "<li><a  href=\"index/lotApprofondi/searchedDeepen/?page=" . $i . $getURL ."\">" . $i . "</a></li>";
                  }
                }
              }
              $i++;
            }
          if($page<$nbPage){
            if(strcmp($lot, "lot")==0){
              echo "<li><a  href=\"index/lot/searched/?page=" . ($page+1) .$getURL . "\"><i class=\"material-icons\">chevron_right</i><span class=\"surfaceText\"></a></li>";
            }
            else{
              echo "<li><a  href=\"index/lotApprofondi/searchedDeepen/?page=" . ($page+1) .$getURL . "\"><i class=\"material-icons\">chevron_right</i><span class=\"surfaceText\"></a></li>";
            }
          }else{
            echo "<li><a><i class=\"grey-text text-lighten-1 material-icons\">chevron_right</i><span class=\"surfaceText\"></a></li>";
          }
        ?>
      </ul>
        </div>
      </div>
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
