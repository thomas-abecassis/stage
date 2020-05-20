
    		<?php
    			echo htmlspecialchars($v->getLogin());
    			echo htmlspecialchars($v->getNom());
    			echo htmlspecialchars($v->getPrenom());
                echo '<a href=index.php?action=delete&controller=utilisateur&id='.htmlspecialchars($v->getLogin()).'>supprimer le compte</a>';
                echo '<a href=index.php?action=update&controller=utilisateur&id='.htmlspecialchars($v->getLogin()).'>mettre à jour le compte </a>';
			?>

