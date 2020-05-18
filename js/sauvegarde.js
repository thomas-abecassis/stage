const isVisible = elem => !!elem && !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length );
let outsideClickListener;
let removeClickListener;

function requeteAJAX(url,callback) {
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		callback(requete);
	});
	requete.send(null);
}

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
		let newP = document.createElement("p");
		newP.classList.add("center");
		newP.style.transition="0.2s";
		newP.style.color="white";
		setTimeout(()=>{
			newP.style.color="red";
		}
	,10);
		newP.textContent="adresse e-mail déjà utilisée";
		racine.appendChild(newP);
	}
}

function popUpCallback(xhr,fctSubmit){
	let page = new DOMParser().parseFromString(xhr.responseText, "text/html");
	page=page.getElementById("racine");
	popUp(page,fctSubmit);
}

function creerSauvegarde(){
	sauvegarde.style["background-color"] = "#f0dcc8";
	sauvegarde.removeEventListener("click",clickHandler);
	sauvegarde.classList.remove("boite_hover");
	requeteAJAX("index.php?controller=alerte&action=created",callback2);
}

function envoieConnexion(){
	mail=document.getElementById("inputMail");
	mdp=document.getElementById("inputMdp");
	requeteAJAX("index.php?controller=utilisateur&action=connectedAjax&login="+mail.value+"&mdp=" +mdp.value,callback1);
}

function envoieCreationCompte(){
	mail=document.getElementById("inputMail");
	mdp=document.getElementById("inputMdp");
	nom=document.getElementById("inputMdp");
	prenom=document.getElementById("inputMdp");
	requeteAJAX("index.php?controller=utilisateur&action=createdAjax&login="+mail.value+"&mdp=" +mdp.value+"&nom=" +nom.value+"&prenom=" +prenom.value,callback6);
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

  	setTimeout(()=>{
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
    outsideClickListener = event => {
        if (!element.contains(event.target) && isVisible(element)) { // or use: event.target.closest(selector) === null
					removePopUp(element);
					removeFond(elementASupprimer);
        }
    }

    removeClickListener = () => {
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

function clickHandler(){
	if(connecte){
		creerSauvegarde();
	}
	else{
		stopScroll();
		lancePopUp();
	}
}

let sauvegarde=document.getElementById("sauvegardeAnnonce");
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
