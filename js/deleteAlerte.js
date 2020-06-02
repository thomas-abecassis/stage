let modifie = false;
let lastName;
let lastInput;
let lastButon;

function callback1(xhr){
	console.log(xhr.responseText);
}

function mettreEvents(){
	let deleteButons=inArray(document.getElementsByClassName("deleteAlerte"));
	let modificationButons=inArray(document.getElementsByClassName("boutonModification"));
	let activationButons=inArray(document.getElementsByClassName("switch"));
	deleteButons.forEach(function(buton){
		buton.addEventListener("click",function(){
			supprimerAlerte(buton);
		});
	});
	modificationButons.forEach(function(buton){
		buton.addEventListener("click",function(){
			modifierAlerte(buton);
		});
	});
	activationButons.forEach(function(buton){
		buton.addEventListener("change",function(){
			activerAlerte(buton);
		});
	});
}

function activerAlerte(buton){
	let id=trouverId(buton);
	requeteAJAX("index.php?controller=alerte&action=active&id="+id,callback1);
}

function supprimerAlerte(buton){
	let id=trouverId(buton);
	requeteAJAX("index.php?controller=alerte&action=delete&id="+id,callback1);
	supprimerBoiteParent(buton);
};

function modifierAlerte(buton){
	lastButon=buton;
	let boite=$(buton).closest(".boite")[0];
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
		i++;
	}
	return idDansEnfants(parent);
}	

function idDansEnfants(element){
	let test = false;
	let children = inArray(element.children);
	for(let i=0;i<children.length;i++){
		if(children[i].classList.contains("idAlerte")){
			return children[i].innerHTML;
		}
	}	
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