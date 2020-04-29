
        <?php
        foreach ($alertes as $alerte)
            echo '<p> <a href=index.php?action=Read&controller=alerte&id='.rawurlencode($alerte->getLoginUtilisateur()).">" . htmlspecialchars($alerte->getNom()) . '</a>.</p>';
        ?>