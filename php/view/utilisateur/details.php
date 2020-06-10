<div  class="container">
    <div class="col s12 m10 l7 offset-m1 offset-l2">
        	<?php
	        	echo '
	     <div class="card " id="modificationCompte">
    		<div>
	        	<p class="grandeTailleFont legerGras">Modifier vos informations</p>

	        	<input type="hidden" id="loginUtilisateur" value='.htmlspecialchars($u->getLogin()).'></input>
				<div class="ligne"></div>
				<p> <span class="legerGras">Nom </span><input id="nomUtilisateur" value='.htmlspecialchars($u->getNom()).'></input></p>
	        	<div class="ligne"></div>
	        	<p> <span class="legerGras">Prenom </span><input id="prenomUtilisateur" value='.htmlspecialchars($u->getPrenom()).'></input></p>
	        	<div class="ligne"></div>';
	        	if(Session::is_admin()){
	        		echo '<p> Role : <span id="role" class="legerGras">'.ucFirst(htmlspecialchars($u->getRoleStr())).'</span></p>';
	        	}

	            echo '

	            <p><div id="boutonUpdateInfos" class=" inputButton secondeCouleur inputButtonCentre">Mettre à jour vos informations </div>              
		            <div id="load" class="displayNone load  text-darken-1">
		            	votre compte a été mis à jour
					  </div>
				  	</p>
				</div>
        	</div>';
if(true){
	echo '	<div class="card " id="modificationCompte">
	    		<div>
		        	<p class="grandeTailleFont legerGras">Modifier votre e-mail</p>
		        	<div class="ligne"></div>
		        	<p><span class="legerGras">E-mail</span><input  id="mailUtilisateur" value='.htmlspecialchars($u->getLogin()).'></input></p>
		        	<div class="ligne"></div>';
		        	if(!Session::is_admin() || Session::is_user(myGet("id"))){
		        		echo'<p><span class="legerGras">Mot de passe</span><input type="password" id="mdpUtilisateurMail" ></input></p>
		        		<div class="ligne"></div>';
		        	}
		            
		            echo '<p><div id="boutonUpdateMail" class=" inputButton secondeCouleur inputButtonCentre">Mettre à jour votre e-mail</div>	              
			            <div id="loadMail" class="displayNone load text-darken-1">
							votre compte a été mis à jour
						  </div>
					  	</p>
	        		</div>
	        	</div>';

	echo '	<div class="card " id="modificationCompte">
	    		<div>
		        	<p class="grandeTailleFont legerGras">Modifier votre mot de passe</p>
		        	<div class="ligne"></div>
		        	<p><span class="legerGras">Nouveau mot de passe</span><input type="password" id="nouveauMdp"></input></p>
		        	<div class="ligne"></div>';
		        	if(!Session::is_admin() || Session::is_user(myGet("id"))){
		        		echo'<p><span class="legerGras">Ancien mot de passe</span><input type="password" id="ancienMdp" ></input></p>
		        		<div class="ligne"></div>';
		        	}

		            echo '<p><div id="boutonUpdateMdp" class=" inputButton secondeCouleur inputButtonCentre">mettre à jour le compte </div>	              
			            <div id="loadMdp" class="displayNone load text-darken-1">
			            	votre compte a été mis à jour
						  </div>
					  	</p>
	        		</div>
	        	</div>';
	}
            ?>
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



