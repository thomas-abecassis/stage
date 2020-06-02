let searchBox=document.getElementById("searchBoxVille");

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
		element.addEventListener("mouseenter",function(){
			children.forEach(function(ville){
				ville.classList.remove("resultWordHover");
			});
			element.classList.add("resultWordHover");
		});
		element.addEventListener("mouseleave",function(){
			element.classList.remove("resultWordHover");
		});
	});
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
	requeteAJAX("php/lib/search.php?mot="+searchBox.value, callback);
}

function callback(xhr){
	if(xhr.responseText!=="false"){
		let tabVilles=JSON.parse(xhr.responseText);
		tabVilles=trierVilles(tabVilles);
		miseEnFormeResultat(tabVilles);
		eventOnCity(); 
	}
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