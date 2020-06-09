document.addEventListener("DOMContentLoaded", function() {

	let arrayGet;

	let boutonUpdateInfos=document.getElementById("boutonUpdateInfos");

	arrayGet={"login" : document.getElementById("loginUtilisateur"), "nom" : document.getElementById("nomUtilisateur"), "prenom" : document.getElementById("prenomUtilisateur")};

	modifie(boutonUpdateInfos,"index/utilisateur/updatedAJAX/?",document.getElementById("load"), arrayGet);

	//si on est admin on ne demande pas de mot de passe donc deux liste de paramètres différentes
	let mdpMail=document.getElementById("mdpUtilisateurMail");
	if(mdpMail!=null){
		arrayGet={"mail" : document.getElementById("mailUtilisateur"), "mdp" :mdpMail};
	}
	else{
		arrayGet={"mail" : document.getElementById("mailUtilisateur"), "oldMail" : document.getElementById("loginUtilisateur")};
	}
	
	modifie(document.getElementById("boutonUpdateMail"), "index/utilisateur/updatedMailAJAX/?", document.getElementById("loadMail"), arrayGet)

	arrayGet={"oldMdp" : document.getElementById("ancienMdp"), "newMdp" : document.getElementById("nouveauMdp")}

	modifie(document.getElementById("boutonUpdateMdp"), "index/utilisateur/updatedMdpAJAX/?", document.getElementById("loadMdp"), arrayGet)
});

function callback(xhr, load){
	console.log(xhr.responseText);
	if(["0","1","2","true"].indexOf(xhr.responseText)>-1){
		notification(load, "votre compte a été mis à jour","green-text");
	}
	else if(xhr.responseText=="no_null_field"){
		notification(load, "vous ne pouvez pas rentrer d'informations vides","red-text");
	}
	else if(xhr.responseText=="mail_allready_taken"){
		notification(load, "ce mail est déjà utilisé par un autre utilisateur","red-text");
	}
	else if(xhr.responseText=="mail_bad_syntax"){
		notification(load, "vérifiez le format de votre mail","red-text");
	}
	else if(xhr.responseText=="bad_password"){
		notification(load, "vérifiez votre mot de passe","red-text");
	}
	else if(xhr.responseText.includes("trueMail")){
		//ce cas correspond au changement de mail par un utilisateur
		//comme l'id de l'utilisateur est mis à jour on recharge la page avec le bon identifiant
		//window.location.href = 'index/utilisateur/Read/?id='+xhr.responseText.replace('trueMail', '');
		document.getElementById("loginUtilisateur").value=xhr.responseText.replace('trueMail', '');
		window.history.pushState('utilisateur', 'Vos paramètres', 'index/utilisateur/Read/?id='+xhr.responseText.replace('trueMail', ''));
	}
}

function modifie(bouton, url, loadElement, getUrl){
	bouton.addEventListener("click", function(){
		for(let param in getUrl){
			url=url + param + "=" + getUrl[param].value + "&";
		}
		console.log(url);
		requeteAJAX(url,function(xhr){
			callback(xhr,loadElement);
		});
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
