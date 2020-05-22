document.addEventListener("DOMContentLoaded", function() {
	let boutonUpdate=document.getElementById("boutonUpdate");

	inputLogin=document.getElementById("loginUtilisateur");
	inputNom=document.getElementById("nomUtilisateur");
	inputPrenom=document.getElementById("prenomUtilisateur");

	boutonUpdate.addEventListener("click", function(){
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