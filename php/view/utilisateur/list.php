	<div class="container">
        <?php
        foreach ($tab_v as $u)
        	if(!$u->isSuperAdmin()){
            echo '<div class="col s12 m10 l7 offset-m1 offset-l2"><p> <span >Login : </span><a class="legerGras" href=index/utilisateur/Read/?id='.rawurlencode($u->getLogin()).">" . htmlspecialchars($u->getLogin()) . '</a></p></div>';
            }
        ?>


        <div class="col s12 m10 l7 offset-m1 offset-l2">
        <ul class="center listeFinDePage">
        <?php
            if($page<=1){
            	echo "<li><a><i class=\" grey-text text-lighten-1 material-icons\">chevron_left</i><span class=\"surfaceText\"></a></li>";
            }
            else{
            	echo "<li><a  href=\"index/utilisateur/readAll/?page=" . ($page-1) . "\"> <i class=\"material-icons\">chevron_left</i><span class=\"surfaceText\"> </a></li>";
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
                  echo "<li class=\"pageSelection\"><a href=\"index/utilisateur/?readAll&page=" . $i  ."\">" . $i . "</a></li>";
                }
                else{
                  echo "<li><a  href=\"index/utilisateur/readAll/?page=" . $i  ."\">" . $i . "</a></li>";
                }
              }
              $i++;
            }
          if($page<$nbPage){
            echo "<li><a  href=\"index/utilisateur/readAll/?page=" . ($page+1) . "\"><i class=\"material-icons\">chevron_right</i><span class=\"surfaceText\"></a></li>";
          }else{
            echo "<li><a><i class=\"grey-text text-lighten-1 material-icons\">chevron_right</i><span class=\"surfaceText\"></a></li>";
          }
        ?>
      </ul>
        </div>
    </div>