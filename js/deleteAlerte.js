let modifie = false;
let lastName;
let lastInput;
let lastButon;

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
}

function mettreEvents(){
	let deleteButons=Array.from(document.getElementsByClassName("deleteAlerte"));
	let modificationButons=Array.from(document.getElementsByClassName("boutonModification"));
	deleteButons.forEach((buton)=>{
		buton.addEventListener("click",()=>{
			supprimerAlerte(buton);
		});
	});
	modificationButons.forEach((buton)=>{
		buton.addEventListener("click",()=>{
			modifierAlerte(buton);
		});
	});
}

function supprimerAlerte(buton){
	let id=trouverId(buton);
	requeteAJAX("index.php?controller=alerte&action=delete&id="+id,callback1);
	supprimerBoiteParent(buton);
};

function modifierAlerte(buton){
	lastButon=buton;
	let boite=buton.closest(".boite");
	let inputNom=boite.getElementsByClassName("modificationNom")[0];
	let displayNom=boite.getElementsByClassName("nomAlerte")[0];
	if(!modifie){
		modifie = true; 
		displayNom.style["display"]="none";
		inputNom.style["display"]="block";
	}else{
		modifie=false;
		displayNom.style["display"]="block";
		inputNom.style["display"]="none";
	}
	inputNom.focus();
	inputNom.selectionStart = inputNom.selectionEnd = inputNom.value.length;
	lastName=displayNom;
	lastInput=inputNom;
}

function supprimerBoiteParent(button){
	let parent=button.parentElement;
	while(!parent.classList.contains("boite")){
		parent=parent.parentElement;
	}
	parent.parentNode.removeChild(parent);
}

function trouverId(element){
	let parent=element.parentElement;
	i=0; //protection pour éviter de faire tourner la boucle indéfiniment
	while(idDansEnfants(parent)===false && i < 5){
		parent=parent.parentElement;
		console.log(parent);
		i++;
	}
	return idDansEnfants(parent);
}	

function idDansEnfants(element){
	let test = false;
	let children = Array.from(element.children);
	for(let i=0;i<children.length;i++){
		if(children[i].classList.contains("idAlerte")){
			return children[i].innerHTML;
		}
	}	
	console.log(test);
	return test;
}

function modifierNom(display,nom){
	display.textContent=nom;
	let id=trouverId(display);
	requeteAJAX("index.php?controller=alerte&action=update&id="+id+"&nom="+nom,callback1);
}

document.onkeydown = function (e) {
    e = e || window.event;
 	if(e.keyCode==13){
	 if(modifie){
	 	modifierAlerte(lastButon);
	 	modifierNom(lastName,lastInput.value);
	 }
    }
};

mettreEvents()