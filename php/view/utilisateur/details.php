<div  class="container">
    <div class="col s12 m10 l7 offset-m1 offset-l2">
        <?php

        	echo '<p> login : <span class="legerGras">'.htmlspecialchars($v->getLogin()).'</span></p>
        	<p> Nom : <span class="legerGras">'.htmlspecialchars($v->getNom()).'</span></p>
        	<p> Prenom : <span class="legerGras">'.htmlspecialchars($v->getPrenom()).'</span></p>
            <p><a href=index.php/utilisateur/update/?&id='.htmlspecialchars($v->getLogin()).'><button>mettre à jour le compte </button></a></p>
            <p><a href=index/utilisateur/delete/?id='.htmlspecialchars($v->getLogin()).'><button class="red-text text-darken-1 ">supprimer le compte</button></a></p>';
    	?>
    </div>
</div>



