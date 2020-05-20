<div  class="container">
    <div class="col s12 m10 l7 offset-m1 offset-l2">
       
    	<div class="card " id="modificationCompte">
    		<form>
        	<?php
	        	echo '
	        	<p>Vos informations</p>
	        	<div class="ligne"></div>
	        	<p> <span class="legerGras">Login </span><input value='.htmlspecialchars($v->getLogin()).'></input></p>
				<div class="ligne"></div>
				<p> <span class="legerGras">Nom </span><input value='.htmlspecialchars($v->getNom()).'></input></p>
	        	<div class="ligne"></div>
	        	<p> <span class="legerGras">Prenom </span><input value='.htmlspecialchars($v->getPrenom()).'></input></p>
	        	<div class="ligne"></div>
	        	<p> Role : <span id="role" class="legerGras">'.htmlspecialchars($v->getRoleStr()).'</span></p>
	        	<div class="ligne"></div>';
	            echo '<p><a href=index/utilisateur/update/?&id='.htmlspecialchars($v->getLogin()).'><button>mettre à jour le compte </button></a></p>';
            ?>
        	</form>
        </div>
            <?php
            if((Session::is_admin() && !Session::is_user($v->getLogin())) || (Session::is_user($v->getLogin() && !Session::is_admin()))){
            	echo '<p><a href=index/utilisateur/delete/?id='.htmlspecialchars($v->getLogin()).'><button class="red-text text-darken-1 ">supprimer le compte</button></a></p>';
       	 	}
        	if(Session::is_admin() && !Session::is_user($v->getLogin())){
        		echo '
        			<div id="cardPrivileges" class="card">
        			Modifier les privilèges de l\'utilisateur
	        			<p>
	        			<button id="boutonSimpleUtilisateur">rendre simple utilisateur</button> 
	        			<button id="boutonCommercial">rendre commercial</button> 
	        			<button id="boutonAdmin">rendre admin</button>
	        			</p>
        			</div>';
        	}
        	if(Session::is_admin()){
        		echo '
        			<script>
        				let nomUtilisateur="'.htmlspecialchars($v->getNom()).'"
        				let prenomUtilisateur="'.htmlspecialchars($v->getPrenom()).'"
        				let loginUtilisateur="'.htmlspecialchars($v->getLogin()).'"
        			</script>
        			 <script src="js/modifierRoleUtilisateur.js" defer></script>';
        	}

    	?>
    </div>
</div>



