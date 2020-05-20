document.addEventListener("DOMContentLoaded", function() {
	let boutonSimpleUtilisateur=document.getElementById("boutonSimpleUtilisateur");
	let boutonCommercial=document.getElementById("boutonCommercial");
	let boutonAdmin=document.getElementById("boutonAdmin");

	if(boutonSimpleUtilisateur!==null){
		boutonSimpleUtilisateur.addEventListener("click", function(){
			requeteAJAX("index/utilisateur/updatedAJAX/?login="+loginUtilisateur+"&nom="+nomUtilisateur+"&role=0",callback);
		});
	}

	if(boutonCommercial!==null){
		boutonCommercial.addEventListener("click", function(){
			requeteAJAX("index/utilisateur/updatedAJAX/?login="+loginUtilisateur+"&nom="+nomUtilisateur+"&role=1",callback);
		});
	}

	if(boutonAdmin!==null){
		boutonAdmin.addEventListener("click", function(){
			requeteAJAX("index/utilisateur/updatedAJAX/?login="+loginUtilisateur+"&nom="+nomUtilisateur+"&role=2",callback);
		});
	}
});

function callback(xhr){
	if(xhr.responseText!="false"){
		if(xhr.responseText=="0"){
			document.getElementById("role").textContent="Simple utilisateur";
		}
		else if(xhr.responseText=="1"){
			document.getElementById("role").textContent="Commercial";
		}
		else if(xhr.responseText=="2"){
			document.getElementById("role").textContent="Admin";
		}
	}
}