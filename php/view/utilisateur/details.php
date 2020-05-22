<div  class="container">
    <div class="col s12 m10 l7 offset-m1 offset-l2">
       
    	<div class="card " id="modificationCompte">
    		<form>
        	<?php
	        	echo '
	        	<p>Vos informations</p>
	        	<div class="ligne"></div>
	        	<p> <span class="legerGras">Login </span><input id="loginUtilisateur" value='.htmlspecialchars($v->getLogin()).'></input></p>
				<div class="ligne"></div>
				<p> <span class="legerGras">Nom </span><input id="nomUtilisateur" value='.htmlspecialchars($v->getNom()).'></input></p>
	        	<div class="ligne"></div>
	        	<p> <span class="legerGras">Prenom </span><input id="prenomUtilisateur" value='.htmlspecialchars($v->getPrenom()).'></input></p>
	        	<div class="ligne"></div>';
	        	if(Session::is_admin()){
	        		echo '<p> Role : <span id="role" class="legerGras">'.ucFirst(htmlspecialchars($v->getRoleStr())).'</span></p>';
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
        		echo '<script src="js/modifierRoleUtilisateur.js" defer></script>';
        	}
        	echo '<script src="js/modifierUtilisateur.js" defer></script>';
    	?>
    </div>
</div>



