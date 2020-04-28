let sauvegarde=document.getElementById("sauvegardeAnnonce");
const isVisible = elem => !!elem && !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length ) 
var xhr= new XMLHttpRequest();
	xhr.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone

    if (xhr.readyState === XMLHttpRequest.DONE) {
	        if(xhr.responseText.valueOf()=="true".valueOf()){
	        	document.location.reload(true);
	        }else{
	        	let co=document.getElementById("connexionBox");
	        	if(co.childElementCount<6){
		        	let p=document.createElement('p');
		        	p.innerHTML="mauvais identifiant ou mot de passe";
		        	p.style.color="red";
		        	p.classList.add("center");	   
		        	co.appendChild(p);
	        	}
	        }
	    }
	});

function creerSauvegarde(){
	sauvegarde.style["background-color"] = "#f0dcc8";
}

function envoieConnexion(){
	console.log("j'envoie");
	mail=document.getElementById("inputMail");
	mdp=document.getElementById("inputMdp");
	xhr.open("get","lib/connexionAjax.php?login="+mail.value+"&mdp=" +mdp.value);
	xhr.send(null);
}

function popUp(){
	let fond = document.createElement("div");
	fond.classList.add("fondTransparent");
	let newDiv = document.createElement("div");
	newDiv.classList.add("card");
	newDiv.style.width="40%";
	newDiv.style.height="40%";
	newDiv.style.top="10%";
	newDiv.style.left="30%";
	newDiv.style.position="fixed";
	newDiv.style.zIndex="1";
	newDiv.style.borderRadius="5px";
  	// et lui donne un peu de contenu
  	// ajoute le nœud texte au nouveau div créé\
  	document.body.appendChild(newDiv);
  	newDiv.innerHTML=getDivConnexion();
  	document.body.appendChild(fond);

  	let boutonConnexion=document.getElementById("boutonConnexion");
  	boutonConnexion.addEventListener("click",function(){
		envoieConnexion();
  	});

  	setTimeout(()=>{
		hideOnClickOutside(newDiv,fond);	
	},10);

}

function getDivConnexion(){
	//string correspondant à la view connexion
	return "<div id=\"searchBox\" class=\" col s6 offset-s3\"><div id=\"connexion\" class=\"row\"><h4 class=  \"center\">Connexion</h4><div id=\"connexionBox\" class=\"col s8 offset-s2  \"><p><input id=\"inputMail\" value= \"\" type=\"text\" placeholder=\"e-mail\" name=\"login\" id=\"immat_id\" required /></p><p><input id=\"inputMdp\" value= \"\" type=\"password\" placeholder=\"mot de passe\" name=\"mdp\" id=\"mdp_id\" required /></p><p ><input id=\"boutonConnexion\" class=\"col s10 offset-s1\" type=\"submit\" value=\"Envoyer\" /></p><input type=\'hidden\' name=\'action\' value=\'connected\'><input type=\'hidden\' name=\'controller\' value=\'utilisateur\'></div></div></div>";
}

function hideOnClickOutside(element,elementASupprimer) {
    const outsideClickListener = event => {
        if (!element.contains(event.target) && isVisible(element)) { // or use: event.target.closest(selector) === null
          element.parentNode.removeChild(element);
          removeClickListener();
          elementASupprimer.parentNode.removeChild(elementASupprimer);
        }
    }

    const removeClickListener = () => {
        document.removeEventListener('click', outsideClickListener);
    }

    document.addEventListener('click', outsideClickListener);
}



sauvegarde.addEventListener("click", function(){
	if(connecte){
		creerSauvegarde();
	}
	else{
		popUp();
	}
});