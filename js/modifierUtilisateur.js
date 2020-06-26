document.addEventListener("DOMContentLoaded", function() {

	let arrayGet;

	let boutonUpdateInfos=document.getElementById("boutonUpdateInfos");

	if(boutonUpdateInfos!==null){
		arrayGet={"login" : document.getElementById("loginUtilisateur"), "nom" : document.getElementById("nomUtilisateur"), "prenom" : document.getElementById("prenomUtilisateur")};

		modifie(boutonUpdateInfos,"index/utilisateur/updatedAJAX/?",document.getElementById("load"), arrayGet);
	}

	//si on est admin on ne demande pas de mot de passe donc deux liste de paramètres différentes
	let boutonUpdateMail = document.getElementById("boutonUpdateMail");
	let mdpMail=document.getElementById("mdpUtilisateurMail");

	if(boutonUpdateMail!==null){
			if(mdpMail!=null){
				arrayGet={"mail" : document.getElementById("mailUtilisateur"), "mdp" :mdpMail};
			}
			else{
				arrayGet={"mail" : document.getElementById("mailUtilisateur"), "oldMail" : document.getElementById("loginUtilisateur")};
			}
			modifie(boutonUpdateMail, "index/utilisateur/updatedMailAJAX/?", document.getElementById("loadMail"), arrayGet)
	}

	let boutonUpdateMdp = document.getElementById("boutonUpdateMdp");

	if(boutonUpdateMdp!==null){
		if(mdpMail!=null){
			arrayGet={"oldMdp" : document.getElementById("ancienMdp"), "newMdp" : document.getElementById("nouveauMdp")};
		}else{
			arrayGet={"newMdp" : document.getElementById("nouveauMdp"), "oldMail" : document.getElementById("loginUtilisateur")};
		}
		modifie(boutonUpdateMdp, "index/utilisateur/updatedMdpAJAX/?", document.getElementById("loadMdp"), arrayGet);
	}
});

function callback(xhr, load){
	if(["0","1","2","3","true"].indexOf(xhr.responseText)>-1){
		notification(load, "le compte a été mis à jour","green-text");
	}
	else if(xhr.responseText=="no_null_field"){
		notification(load, "vous ne pouvez pas rentrer d'informations vides","red-text");
	}
	else if(xhr.responseText=="mail_allready_taken"){
		notification(load, "ce mail est déjà utilisé par un autre utilisateur","red-text");
	}
	else if(xhr.responseText=="mail_bad_syntax"){
		notification(load, "vérifiez le format du mail","red-text");
	}
	else if(xhr.responseText=="bad_password"){
		notification(load, "vérifiez le mot de passe","red-text");
	}
	else if(xhr.responseText.includes("trueMail")){
		//ce cas correspond au changement de mail par un utilisateur
		//comme l'id de l'utilisateur est mis à jour on le met à jour dans notre element
		//on change aussi l'url du navigateur pour éviter une erreur lors d'un F5
		document.getElementById("loginUtilisateur").value=xhr.responseText.replace('trueMail', '');
		window.history.pushState('utilisateur', 'Vos paramètres', 'index/utilisateur/Read/?id='+xhr.responseText.replace('trueMail', ''));
		notification(load, "le compte a été mis à jour","green-text");
	}
}

function modifie(bouton, url, loadElement, getUrl){
	bouton.addEventListener("click", function(){
		let startUrl=url;
		//console.log(getUrl);
		for(let param in getUrl){
			url=url + param + "=" + getUrl[param].value + "&";
		}
		//console.log(url);
		requeteAJAX(url,function(xhr){
			callback(xhr,loadElement);
		});
		url=startUrl;
	});
}


function notification(load,text,color){
	load.textContent=text;
	load.classList.remove("displayNone");
	load.classList.remove("green-text");
	load.classList.remove("red-text");
	load.classList.add(color);
	setTimeout(function(){ load.classList.add("displayNone");}, 3000);
}
