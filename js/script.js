function requeteAJAX(url,callback) {
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		callback(requete);
	});
	requete.send(null);
}

function inArray(arr){
	let tmp=[];
	for(let i=0;i<arr.length;i++){
		tmp.push(arr[i]);
	}
	return tmp;
}

const isVisible= function(elem) { return !!elem && !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length )};
let outsideClickListener;
let removeClickListener;
let sauvegarde;

function callbackIdentifiantCheck(xhr){
	console.log(xhr.responseText);
	if(xhr.responseText.replace(/ /g, '')=="true".valueOf()){
		console.log("je reload");
	    document.location.reload(true);
	}else{
		notification("mauvais identifiant ou mot de passe");
	}
}

function callbackRechercheSave(xhr){
	console.log(xhr.responseText);
	document.getElementById("inSauvegarde").innerHTML="recherche sauvegardée !";
}

function reload(xhr){
	document.location.reload(true);
}

function callbackCreationCheck(xhr){
	console.log(xhr.responseText);
	let racine=document.getElementById("racineCard");
	if(xhr.responseText.valueOf()=="register"){
		racine.innerHTML="  <p class=\"center\"><i class=\"green-text small material-icons\">check</i> </p><p class=\"center\">Votre compte a été créé</p><div class=\"ligne\"></div><p class=\"center\">Vous pouvez maintenant vous connecter</p>";
	}
	else if(xhr.responseText.valueOf()=="bad_mail_syntax"){
		notification("mauvais fomat d'adresse e-mail");
	}else if(xhr.responseText.valueOf()=="mail_allready_taken"){
		notification("Un compte existe déjà avec cette adresse e-mail");
	}else{
		notification("Le compte n'a pas pu être créé");
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
	requeteAJAX("index/alerte/created/",callbackRechercheSave);
}

function envoieConnexion(){
	mail=document.getElementById("inputMail").value;
	mdp=document.getElementById("inputMdp").value;
	requeteAJAX("index/utilisateur/connectedAjax/?login="+mail+"&mdp=" +mdp,callbackIdentifiantCheck);
}

function envoieCreationCompte(){
	mail=document.getElementById("inputMail").value;
	nom=document.getElementById("inputNom").value;
	prenom=document.getElementById("inputPrenom").value;
	mdp=document.getElementById("inputMdp").value;
	confirmMdp=document.getElementById("confirmMdp").value;
	if(mdp==confirmMdp){
		requeteAJAX("index/utilisateur/createdAjax/?login="+mail+"&mdp=" +mdp+"&nom=" +nom+"&prenom=" +prenom,callbackCreationCheck);
	}
	else{
		notification("les mots de passes ne correspondent pas");
	}
}

function deconnect(){
	requeteAJAX("index/utilisateur/disconnectAjax/",reload);
}

function popUp(page,fctSubmit){
	let fond=getFond();
	let newDiv = document.createElement("div");
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
		fond = document.getElementsByClassName("fondTransparent")[0];
		return fond;
	}
	fond = document.createElement("div");
	fond.classList.add("fondTransparent");
	return fond;
}

function lancePopUpConnexion(){
	requeteAJAX("php/view/utilisateur/connect.php",function(xhr){
		popUpCallback(xhr,envoieConnexion);
	});
}

function lancePopUpCreationCompte(){
	requeteAJAX("php/view/utilisateur/update.php",function(xhr){
		popUpCallback(xhr,envoieCreationCompte);
	});
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
        if (!element.contains(event.target) && isVisible(element)) {
					removePopUp(element);
					removeFond(elementASupprimer);
        }
    }

    removeClickListener = function() {
        document.removeEventListener('mousedown', outsideClickListener);
        let close=document.getElementById("close");
    }

    let close=document.getElementById("close");
    close.addEventListener("click",function(){
    	removePopUp(element);
		removeFond(elementASupprimer);
    });

    document.addEventListener('mousedown', outsideClickListener);
}

function removePopUp(element){
	var instance = M.Sidenav.getInstance(document.getElementById("slide-out"));
	instance.close();
	element.parentNode.removeChild(element);
	removeClickListener();
	canScroll();
}

function removeFond(fond){
	fond.parentNode.removeChild(fond);
}

var canNotif=true;

function notification(text){
	if(!canNotif) return;
	canNotif=false;
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
	if(racine!==null){
		racine.appendChild(newP);
	}
	setTimeout(function(){
		newP.parentNode.removeChild(newP);
		canNotif=true;
	}, 1000);
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

function createColorPicker(element,variableCouleur){
	var picker = new Picker(element);

	picker.onChange = function(color) {
		modifierCouleur(variableCouleur,color.rgbaString);
	};

	picker.onDone = function(color){
		let url;
		if(variableCouleur=="premiereCouleur"){
			url="index/Utility/changerCouleur/?secondColor="+previousSecondColor+"&mainColor="+color.rgbaString;
			previousMainColor=color.rgbaString;
		}
		else{
			url="index/Utility/changerCouleur/?secondColor="+color.rgbaString+"&mainColor="+previousMainColor;
			previousSecondColor=color.rgbaString;
		}
		requeteAJAX(url,callbackCouleur);
		checkCouleur=true;
	}

	picker.onOpen = function(){
		checkCouleur=false;
	}

	picker.onClose = function(color){
		if (!window.document.documentMode) {
			setTimeout(function () {
		        if (!checkCouleur) {
		        	if(variableCouleur=="premiereCouleur"){
		        		modifierCouleur("premiereCouleur",previousMainColor); 
					}
					else{
						modifierCouleur("secondeCouleur",previousSecondColor); 
					}
		        }
		    }, 10);
			
		}
	}
}


function callbackCouleur(xhr){
	console.log(xhr.responseText);
}

function modifierCouleur(nomCouleur, couleur){
	let selects = document.getElementsByClassName(nomCouleur);
 	for(let i =0, il = selects.length;i<il;i++){
     	selects[i].setAttribute('style', 'background-color :  '+couleur+' !important');
  	}
  	selects = document.getElementsByClassName(nomCouleur+"Text");
 	for(let i =0, il = selects.length;i<il;i++){
 		selects[i].setAttribute('style', 'color : '+couleur+' !important');
 	}
  	selects = document.getElementsByClassName(nomCouleur+"Border");
 	for(let i =0, il = selects.length;i<il;i++){
 		selects[i].setAttribute('style', 'border-color :  '+couleur+' !important');
  	}
}

function modifieImage(input,element){
	element.src=window.URL.createObjectURL(input.files[0]);
}

function modifieImageStyle(input,element){
	element.style.backgroundImage = "url('" + window.URL.createObjectURL(input.files[0]) + "')";
}

function metAJourImage(ev,form,nomFichier){
	oData = new FormData(form);
	oData.append("nomFichier", nomFichier);
	var oReq = new XMLHttpRequest();
	oReq.open("POST", "index/Utility/saveImage/", true);
	oReq.onload = function(oEvent) {
	    callbackPhoto(oReq);
	};
	oReq.send(oData);
}

function callbackPhoto(xhr){
	console.log(xhr.responseText);
	//document.location.reload(true);
}

function compareElementValue(elementX, elementY){
	return elementX.value && elementY.value && elementX.value > elementY.value;
}

function majInformations(form, action, name, input){
	form.addEventListener("submit", function(ev){
		ev.preventDefault();
		requeteAJAX("index/Utility/" + action + "/?nomOption="+ name +"&valeur="+input.value,reload);
	});
}

function activerReseau(checkbox, name){
	checkbox.addEventListener("click", function(ev){
		requeteAJAX("index/Utility/activerReseauSocial/?nomOption="+ name ,function(xhr){
			console.log(xhr.responseText);
		});
	});
}

document.addEventListener("DOMContentLoaded", function() {
	
	sauvegarde=document.getElementById("sauvegardeAnnonce");

	if(sauvegarde!==null){
		sauvegarde.addEventListener("click", clickHandler);
	}

	//connexion1 et creationCompteBouton1 correspondent aux <a> dans le menu "Desktop" (en haut à droite)
	let connexion1=document.getElementById("connexion1");
	if(connexion1!==null){
		connexion1.addEventListener("click", lancePopUpConnexion);
	}


	let creationCompteBouton1=document.getElementById("creationCompte1");
	if(creationCompteBouton1!==null){
		creationCompteBouton1.addEventListener("click",  lancePopUpCreationCompte);
	}

	//eux correspondent aux <a> dans le burger menu
	let connexion2=document.getElementById("connexion2");
	if(connexion2!==null){
		connexion2.addEventListener("click", lancePopUpConnexion);
	}

	let creationCompteBouton2=document.getElementById("creationCompte2");
	if(creationCompteBouton2!==null){
		creationCompteBouton2.addEventListener("click",  lancePopUpCreationCompte);
	}

	let deconnexion1=document.getElementById("deconnexion1");
	if(deconnexion1!==null){
		deconnexion1.addEventListener("click", deconnect);
	}

	let deconnexion2=document.getElementById("deconnexion2");
	if(deconnexion2!==null){
		deconnexion2.addEventListener("click", deconnect);
	}

	window.addEventListener('resize', function(){
		if(window.matchMedia("(min-width: 1101px)").matches){
			var instance = M.Sidenav.getInstance(document.getElementById("slide-out"));
			instance.close();			
		}
	});


	let picker1 = document.querySelector('#colorPicker1');
	let picker2 = document.querySelector('#colorPicker2');
	//dans la page html il y a toujours ces elements en display none
	previousMainColor=window.getComputedStyle(document.getElementById("premiereCouleur")).getPropertyValue('color');
	previousSecondColor=window.getComputedStyle(document.getElementById("secondeCouleur")).getPropertyValue('color');

	let checkCouleur=false;

	createColorPicker(picker1,"premiereCouleur");
	createColorPicker(picker2,"secondeCouleur");

	let inputPhotoLogo=document.getElementById("inputPhotoLogo");

		if(inputPhotoLogo!=null){
			var formLogo = document.getElementById("formLogo");
			let inputPhotoBanniere=document.getElementById("inputPhotoBanniere");
			var formBanniere = document.getElementById("formBanniere");
			let formIcon=document.getElementById("formIcon");

			let formTel=document.getElementById("formTel");

			majInformations(document.getElementById("formMail"),"updateOptionSite", "Mail", document.getElementById("inputModifyMail"));
			majInformations(document.getElementById("formTel"),"updateOptionSite", "Telephone", document.getElementById("inputModifyTel"));
			majInformations(document.getElementById("formFacebook"),"updateLienReseau", "Facebook", document.getElementById("inputModifyFacebook"));
			majInformations(document.getElementById("formTwitter"),"updateLienReseau", "Twitter", document.getElementById("inputModifyTwitter"));
			majInformations(document.getElementById("formLinkedin"),"updateLienReseau", "Linkedin", document.getElementById("inputModifyLinkedin"));
			majInformations(document.getElementById("formInstagram"),"updateLienReseau", "Instagram", document.getElementById("inputModifyInstagram"));

			activerReseau(document.getElementById("checkFacebook"), "Facebook");
			activerReseau(document.getElementById("checkTwitter"), "Twitter");
			activerReseau(document.getElementById("checkLinkedin"), "Linkedin");
			activerReseau(document.getElementById("checkInstagram"), "Instagram");

			inputPhotoLogo.addEventListener('change', function() {
				modifieImage(this,document.getElementById("logo"));
			});

			formLogo.addEventListener('submit', function(ev) {
				ev.preventDefault();
				metAJourImage(ev,formLogo,"logo");
			});

			formLogo.addEventListener('submit', function(ev) {
				ev.preventDefault();
				metAJourImage(ev,formLogo,"logo");
			});

			inputPhotoBanniere.addEventListener('change', function() {
				modifieImageStyle(this,document.getElementById("banniere"));
			});

			formBanniere.addEventListener('submit', function(ev) {
				ev.preventDefault();
				metAJourImage(ev,formBanniere,"banniere");
			});

			formIcon.addEventListener('submit', function(ev) {
				ev.preventDefault();
				metAJourImage(ev,formIcon,"favicon");
			});


		}

	$('.sidenav').sidenav();
    $('.modal').modal();
	$('.dropdown-trigger').dropdown({
	 	'coverTrigger':false
	});
	$('.tabs').tabs();

	
	let submit=document.getElementById("submitForm");

	if (submit!==null){
		let minEur=document.getElementById("minEur");
		let maxEur=document.getElementById("maxEur");

		let minSurface=document.getElementById("minSurface");
		let maxSurface;
		if(minSurface!==null){
			maxSurface=document.getElementById("maxSurface");
		}

		submit.addEventListener("submit",function(event){
			if(compareElementValue(minEur, maxEur)){
				event.preventDefault();
				let notEur=document.getElementById("notifEur");
				notEur.classList.remove("displayNone");
			}
			if(minSurface!==null && compareElementValue(minSurface, maxSurface)){
				event.preventDefault();
				let notSurface=document.getElementById("notifSurface");
				notSurface.classList.remove("displayNone");
			}
		});
	}
});


