<div  class="container">
    <div class="col s12 m10 l7 offset-m1 offset-l2">
       
    	<div class="card " id="modificationCompte">
    		<form>
        	<?php
	        	echo '
	        	<p class="center grandeTailleFont legerGras">Modifier vos informations</p>
	        	<div class="ligne"></div>
	        	<p> <span class="legerGras">Login </span><input id="loginUtilisateur" value='.htmlspecialchars($u->getLogin()).'></input></p>
				<div class="ligne"></div>
				<p> <span class="legerGras">Nom </span><input id="nomUtilisateur" value='.htmlspecialchars($u->getNom()).'></input></p>
	        	<div class="ligne"></div>
	        	<p> <span class="legerGras">Prenom </span><input id="prenomUtilisateur" value='.htmlspecialchars($u->getPrenom()).'></input></p>
	        	<div class="ligne"></div>';
	        	if(Session::is_admin()){
	        		echo '<p> Role : <span id="role" class="legerGras">'.ucFirst(htmlspecialchars($u->getRoleStr())).'</span></p>';
	        	}

	            echo '

	            <p><div id="boutonUpdate" class=" inputButton secondeCouleur inputButtonCentre">mettre à jour le compte </div>	              
		            <div id="load" class="displayNone absolute preloader-wrapper active">
					    <div class="spinner-layer premiereCouleurBorder">
					      <div class="circle-clipper left">
					        <div class="circle"></div>
					      </div><div class="gap-patch">
					        <div class="circle"></div>
					      </div><div class="circle-clipper right">
					        <div class="circle"></div>
					      </div>
					    </div>
					  </div>
				  </p>';
            ?>
        	</form>
        </div>
            <?php
            if(!$u->isAdmin() || Session::is_super_admin()){
            	echo '<p><form action="index/utilisateur/delete/?id='.htmlspecialchars($u->getLogin()).'"><button class="red-text text-darken-1 ">supprimer le compte</button></form></p>';
       	 	}
        	if((Session::is_admin() && !$u->isAdmin()) || Session::is_super_admin()){
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
        	if((Session::is_admin() && !$u->isAdmin()) || Session::is_super_admin()){
        		echo '<script src="js/modifierRoleUtilisateur.js" defer></script>';
        	}
        	echo '<script src="js/modifierUtilisateur.js" defer></script>';
    	?>
    </div>
</div>



