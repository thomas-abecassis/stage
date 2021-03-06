document.addEventListener("DOMContentLoaded", function() {
	let boutonSimpleUtilisateur=document.getElementById("boutonSimpleUtilisateur");
	let boutonCommercial=document.getElementById("boutonCommercial");
	let boutonAdmin=document.getElementById("boutonAdmin");

	loginUtilisateur=document.getElementById("loginUtilisateur").value;
	nomUtilisateur=document.getElementById("nomUtilisateur").value;
	prenomUtilisateur=document.getElementById("prenomUtilisateur").value;

	if(boutonSimpleUtilisateur!==null && boutonCommercial!==null && boutonAdmin!==null){
		boutonSimpleUtilisateur.addEventListener("click", function(){
			requeteAJAX("index/utilisateur/updatedAJAX/?login="+loginUtilisateur+"&nom="+nomUtilisateur+"&prenom="+prenomUtilisateur+"&role=0",callbackAdmin);
		});
		boutonAdmin.addEventListener("click", function(){
			requeteAJAX("index/utilisateur/updatedAJAX/?login="+loginUtilisateur+"&nom="+nomUtilisateur+"&prenom="+prenomUtilisateur+"&role=2",callbackAdmin);
		});
		boutonCommercial.addEventListener("click", function(){
			requeteAJAX("index/utilisateur/updatedAJAX/?login="+loginUtilisateur+"&nom="+nomUtilisateur+"&prenom="+prenomUtilisateur+"&role=1",callbackAdmin);
		});
	}
});

function callbackAdmin(xhr){
	//console.log(xhr.responseText);
	if(xhr.responseText!="false"){
		if(xhr.responseText=="0"){
			document.getElementById("role").textContent="Simple utilisateur";
		}
		else if(xhr.responseText=="1"){
			document.getElementById("role").textContent="Commercial";
		}
		else if(xhr.responseText=="2"){
			document.getElementById("role").textContent="Admin";
			document.location.reload(true);
		}
	}
}