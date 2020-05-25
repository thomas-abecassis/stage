let searchBox=document.getElementById("searchBoxVille");

var xhr2= new XMLHttpRequest();
	xhr2.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone

    if (xhr2.readyState === XMLHttpRequest.DONE && searchBox.value.length!==0) {
    	if(xhr2.responseText!=="false"){
    		let tabVilles=JSON.parse(xhr2.responseText);
    		tabVilles=trierVilles(tabVilles);
    		miseEnFormeResultat(tabVilles);
    		eventOnCity(); 
    	}
	    }
	});

searchBox.addEventListener("input", function(){
	search();
	if(searchBox.value.length==0){
		document.getElementById('resultSearchVille').innerHTML="";
	}
});

function trierVilles(tabVilles){
	let input=searchBox.value;
	tabVilles.sort(function(a,b){return nombreLettreEnCommun(input,a)-nombreLettreEnCommun(input,b)});
	return tabVilles;
}

function nombreLettreEnCommun(input,ville){
	let nbDifferent=0;
	for(let i=0; i<input.length; i++){
		if(input[i]!==ville.nom[i]){
			nbDifferent++;
		}
	}
	nbDifferent+=ville.nom.length-input.length;
	return nbDifferent;
}

function eventOnCity(){
	let children = inArray(document.getElementById("resultSearchVille").children);
	if(children.length > 0){
			children[0].classList.add("resultWordHover");
	}
	children.forEach(function(element){
		element.addEventListener("click",function(){searchBox.value=element.innerHTML.split("(")[0].trim();
		document.getElementById('resultSearchVille').innerHTML="";});
	}
	);
}

function miseEnFormeResultat(tabVilles){
		let div;
		let result=document.getElementById('resultSearchVille');
		result.innerHTML="";
		tabVilles.forEach(function(ville){
			div=document.createElement("div");
			div.textContent=ville.nom+ " (" +ville.codePostal + ")";
			div.classList.add("resultWord");
			result.appendChild(div);
		});
}


function indexHover(){
	let children = inArray(document.getElementById("resultSearchVille").children);
	let i=0;
	let e=-1;
	children.forEach(function(element){
		if(element.classList.contains("resultWordHover")){
			e=i;
		}
		i++;
	}
	);
	return e;
}

function search(){	
	xhr2.open("get", "php/lib/search.php?mot="+searchBox.value, true);
	xhr2.send(null);
}

document.onkeydown = function (e) {
    e = e || window.event;
    let children = inArray(document.getElementById("resultSearchVille").children);
    let ih=indexHover();
    if(children.length!=0){
	    if(ih===-1 && e.keyCode==40){
	    	children[0].classList.add("resultWordHover");
    	}	    
    	else if(e.keyCode==40 && ih!=children.length-1){
	    	children[ih+1].classList.add("resultWordHover");
	    	children[ih].classList.remove("resultWordHover");
    	}    	
    	else if(e.keyCode==38 && ih!=0){
	    	children[ih-1].classList.add("resultWordHover");
	    	children[ih].classList.remove("resultWordHover");
    	}else if(e.keyCode==13){
    	event.preventDefault();
    	searchBox.value=children[ih].innerHTML.split("(")[0].trim();
		document.getElementById('resultSearchVille').innerHTML="";
    	}
	}
};

let searchBoxCard=document.getElementById("searchBox");
searchBoxCard.addEventListener( "click", function() {
	let elementHover=document.getElementsByClassName("resultWordHover");
	if(elementHover.length>0){
		elementHover=elementHover[0];
		searchBox.value=elementHover.innerHTML.split("(")[0].trim();
		document.getElementById('resultSearchVille').innerHTML="";
	}	
});