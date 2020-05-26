	<div class="container">
        <?php
        foreach ($tab_v as $u)
        	if(!$u->isSuperAdmin()){
            echo '<div class="col s12 m10 l7 offset-m1 offset-l2"><p> <span >Login : </span><a class="legerGras" href=index/utilisateur/Read/?id='.rawurlencode($u->getLogin()).">" . htmlspecialchars($u->getLogin()) . '</a></p></div>';
            }
        ?>
    </div>