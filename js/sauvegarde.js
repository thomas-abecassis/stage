const isVisible = elem => !!elem && !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length );

function requeteAJAX(url,callback) {
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		callback(requete);
	});
	requete.send(null);
}

function callback1(xhr){
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

function callback2(xhr){
	console.log(xhr.responseText);
	document.getElementById("inSauvegarde").innerHTML="recherche sauvegardée !";
}

function callback3(xhr){
	let page = new DOMParser().parseFromString(xhr.responseText, "text/html");
	page=page.documentElement;
	page=page.getElementsByClassName("container")[0];
	page=page.firstElementChild;
	popUp(page);
}


function creerSauvegarde(){
	sauvegarde.style["background-color"] = "#f0dcc8";
	sauvegarde.removeEventListener("click",clickHandler);
	sauvegarde.classList.remove("boite_hover");
	requeteAJAX("index.php?controller=alerte&action=created",callback2);
}

function envoieConnexion(){
	console.log("j'envoie");
	mail=document.getElementById("inputMail");
	mdp=document.getElementById("inputMdp");
	requeteAJAX("lib/connexionAjax.php?login="+mail.value+"&mdp=" +mdp.value,callback1);
}

function popUp(page){
	let fond = document.createElement("div");
	fond.classList.add("fondTransparent");
	let newDiv = document.createElement("div");
	newDiv.style.position="fixed";
	newDiv.style.top="20%";
	newDiv.style.left="40%";
	newDiv.style.width="20%";
	newDiv.style.zIndex="3";
  	// et lui donne un peu de contenu
  	// ajoute le nœud texte au nouveau div créé\
  	document.body.appendChild(newDiv);
  	newDiv.appendChild(page);
  	document.body.appendChild(fond);

  	let boutonConnexion=document.getElementById("boutonConnexion");
  	boutonConnexion.addEventListener("click",function(){
		envoieConnexion();
  	});

  	setTimeout(()=>{
		hideOnClickOutside(newDiv,fond);
	},10);
}

function lancePopUp(){
	requeteAJAX("view/utilisateur/connect.php",callback3);
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
    const outsideClickListener = event => {
        if (!element.contains(event.target) && isVisible(element)) { // or use: event.target.closest(selector) === null
          element.parentNode.removeChild(element);
          removeClickListener();
          elementASupprimer.parentNode.removeChild(elementASupprimer);
					canScroll();
        }
    }

    const removeClickListener = () => {
        document.removeEventListener('click', outsideClickListener);
    }

    document.addEventListener('click', outsideClickListener);
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
	connexion.addEventListener("click", lancePopUp);
}
