const isVisible= function(elem) { return !!elem && !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length )};
let outsideClickListener;
let removeClickListener;
let sauvegarde;

function callback1(xhr){
	console.log(xhr.responseText);
	if(xhr.responseText.valueOf()=="true".valueOf()){
	    document.location.reload(true);
	}else{
		let co=document.getElementById("racineCard");
	    if(co.childElementCount<6){
		    let p=document.createElement('p');
		    p.innerHTML="mauvais identifiant ou mot de passe";
		    p.style.color="red";
		    p.classList.add("center");
		    co.appendChild(p);
	    }
	}
}

function callback2(xhr){
	console.log(xhr.responseText);
	document.getElementById("inSauvegarde").innerHTML="recherche sauvegardée !";
}

function callback3(xhr){
	popUpCallback(xhr,envoieConnexion);
}

function callback5(xhr){
	popUpCallback(xhr,envoieCreationCompte);
}

function callback4(xhr){
	document.location.reload(true);
}

function callback6(xhr){
	console.log(xhr.responseText);
	let racine=document.getElementById("racineCard");
	if(xhr.responseText.valueOf()=="true"){
		console.log("je suis passé là");
		racine.innerHTML="<p>Votre compte a été créé</p>";
	}
	else{
		notification("mauvais fomat d'adresse e-mail");
	}
}

function popUpCallback(xhr,fctSubmit){
	let page = new DOMParser().parseFromString(xhr.responseText, "text/html");
	page=page.getElementById("racine");
	popUp(page,fctSubmit);
}

function creerSauvegarde(){
	let rgb=getComputedStyle(document.documentElement).getPropertyValue('--secondColor');
	rgb = rgb.replace(/[^\d,]/g, '').split(',');
	sauvegarde.style.setProperty("background-color", lighten(rgb,1.1), "important");
	sauvegarde.removeEventListener("click",clickHandler);
	sauvegarde.classList.remove("boite_hover");
	requeteAJAX("index.php?controller=alerte&action=created",callback2);
}

function envoieConnexion(){
	mail=document.getElementById("inputMail").value;
	mdp=document.getElementById("inputMdp").value;
	requeteAJAX("index.php?controller=utilisateur&action=connectedAjax&login="+mail+"&mdp=" +mdp,callback1);
}

function envoieCreationCompte(){
	mail=document.getElementById("inputMail").value;
	nom=document.getElementById("inputNom").value;
	prenom=document.getElementById("inputPrenom").value;
	mdp=document.getElementById("inputMdp").value;
	confirmMdp=document.getElementById("confirmMdp").value;
	if(mdp==confirmMdp){
		requeteAJAX("index.php?controller=utilisateur&action=createdAjax&login="+mail+"&mdp=" +mdp+"&nom=" +nom+"&prenom=" +prenom,callback6);
	}
	else{
		notification("les mots de passes ne correspondent pas");
	}
}

function deconnect(){
	requeteAJAX("index.php?controller=utilisateur&action=disconnectAjax",callback4);
}

function popUp(page,fctSubmit){
	let fond=getFond();

	let newDiv = document.createElement("div");
	newDiv.style.position="fixed";
	newDiv.style.top="20%";
	newDiv.style.left="40%";
	newDiv.style.width="20%";
	newDiv.style.zIndex="3";
	newDiv.id="boxFixed";
  	// et lui donne un peu de contenu
  	// ajoute le nœud texte au nouveau div créé\
  	document.body.appendChild(newDiv);
  	newDiv.appendChild(page);
  	document.body.appendChild(fond);

  	let formConnexion=document.getElementById("formConnexion");
  	formConnexion.addEventListener("submit",function(){
  		event.preventDefault();
			fctSubmit();
  	});

		let boutonRedirectCreation=document.getElementById("boutonRedirectCreation");
		if(boutonRedirectCreation!==null){
			boutonRedirectCreation.addEventListener("click",function(){
				removePopUp(newDiv);
				lancePopUpCreationCompte();
			});
	}

  	setTimeout(function(){
		hideOnClickOutside(newDiv,fond);
	},10);
}

function isFond(){
	return document.getElementsByClassName("fondTransparent").length!==0;
}

function getFond(){
	if(isFond()){
		return document.getElementsByClassName("fondTransparent")[0];
	}
	fond = document.createElement("div");
	fond.classList.add("fondTransparent");
	return fond;
}

function lancePopUpConnexion(){
	requeteAJAX("php/view/utilisateur/connect.php",callback3);
}

function lancePopUpCreationCompte(){
	requeteAJAX("php/view/utilisateur/update.php",callback5);
}

function stopScroll(){
	document.body.style.overflow="hidden";
	//code prit de stackOverflow
	$(document).bind('scroll',function () {
				window.scrollTo(0,0);
	});
}

function canScroll(){
	$(document).unbind('scroll');
  document.body.style.overflow="visible";
}

function hideOnClickOutside(element,elementASupprimer) {
    outsideClickListener = function(event) {
        if (!element.contains(event.target) && isVisible(element)) { // or use: event.target.closest(selector) === null
					removePopUp(element);
					removeFond(elementASupprimer);
        }
    }

    removeClickListener = function() {
        document.removeEventListener('mousedown', outsideClickListener);
    }

    document.addEventListener('mousedown', outsideClickListener);
}

function removePopUp(element){
	element.parentNode.removeChild(element);
	removeClickListener();
	canScroll();
}

function removeFond(fond){
	fond.parentNode.removeChild(fond);
}

function notification(text){
	let racine=document.getElementById("racineCard");
	let newP = document.createElement("p");
	newP.classList.add("center");
	newP.style.transition="0.2s";
	newP.style.color="white";
	setTimeout(function(){
		newP.style.color="red";
	}
	,10);
	newP.textContent=text;
	racine.appendChild(newP);
}


function clickHandler(){
	if(connecte){
		creerSauvegarde();
	}
	else{
		stopScroll();
		lancePopUpConnexion();
	}
}

function lighten(rgb,ratio){
	r=parseInt(rgb[0])*ratio;
	g=parseInt(rgb[1])*ratio;
	b=parseInt(rgb[2])*ratio;
	return "rgb("+r+" , "+ g+" , "+b+")";
}

document.addEventListener("DOMContentLoaded", function() {
	
	sauvegarde=document.getElementById("sauvegardeAnnonce");

	if(sauvegarde!==null){
		sauvegarde.addEventListener("click", clickHandler);
	}

	let connexion=document.getElementById("connexion");
	if(connexion!==null){
		connexion.addEventListener("click", lancePopUpConnexion);
	}

	let deconnexion=document.getElementById("deconnexion");
	if(deconnexion!==null){
		deconnexion.addEventListener("click", deconnect);
	}

	let creationCompteBouton=document.getElementById("creationCompte");
	if(creationCompteBouton!==null){
		creationCompteBouton.addEventListener("click",  lancePopUpCreationCompte);
	}
});


