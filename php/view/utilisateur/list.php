
        <?php
        foreach ($tab_v as $v)
            echo '<p> utilisateur de login <a href=index/utilisateur/Read/?id='.rawurlencode($v->getLogin()).">" . htmlspecialchars($v->getLogin()) . '</a>.</p>';
        ?>
