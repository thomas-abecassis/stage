document.addEventListener("DOMContentLoaded", function() {
	let boutonUpdateInfos=document.getElementById("boutonUpdateInfos");

	let inputLogin=document.getElementById("loginUtilisateur");
	let inputNom=document.getElementById("nomUtilisateur");
	let inputPrenom=document.getElementById("prenomUtilisateur");

	boutonUpdateInfos.addEventListener("click", function(){
		requeteAJAX("index/utilisateur/updatedAJAX/?login="+inputLogin.value+"&nom="+inputNom.value+"&prenom="+inputPrenom.value,callback);
		document.getElementById("load").classList.remove("displayNone");
	});

	let boutonUpdateMail=document.getElementById("boutonUpdateMail");

	let email=document.getElementById("mailUtilisateur");
	let mdp=document.getElementById("mdpUtilisateurMail");

	boutonUpdateMail.addEventListener("click", function(){
		requeteAJAX("index/utilisateur/updatedMailAJAX/?mail="+email.value+"&mdp="+mdp.value,callback);
		document.getElementById("load").classList.remove("displayNone");
	});


	let boutonUpdateMdp=document.getElementById("boutonUpdateMdp");

	let ancienMdp=document.getElementById("ancienMdp");
	let nouveauMdp=document.getElementById("nouveauMdp");

	boutonUpdateMdp.addEventListener("click", function(){
		requeteAJAX("index/utilisateur/updatedAJAX/?login="+inputLogin.value+"&nom="+inputNom.value+"&prenom="+inputPrenom.value,callback);
		document.getElementById("load").classList.remove("displayNone");
	});
});

function callback(xhr){
	console.log(xhr.responseText);
	if(xhr.responseText!="false"){
		document.getElementById("load").classList.add("displayNone");
	}

}