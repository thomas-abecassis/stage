function createColorPicker(element,variableCouleur){
	var picker = new Picker(element);

	picker.onChange = function(color) {
		modifierCouleur(variableCouleur,color.rgbaString);
	};

	picker.onDone = function(color){
		let url;
		if(variableCouleur=="premiereCouleur"){
			url="index/Utility/changerCouleur/?secondColor="+previousSecondColor+"&mainColor="+color.rgbaString;
			previousMainColor=color.rgbaString;
		}
		else{
			url="index/Utility/changerCouleur/?secondColor="+color.rgbaString+"&mainColor="+previousMainColor;
			previousSecondColor=color.rgbaString;
		}
		console.log(url);
		requeteAJAX(url,callbackCouleur);
		checkCouleur=true;
	}

	picker.onOpen = function(){
		checkCouleur=false;
	}

	picker.onClose = function(color){
		if (!window.document.documentMode) {
			setTimeout(function () {
		        if (!checkCouleur) {
		        	if(variableCouleur=="premiereCouleur"){
		        		console.log("je set");
		        		modifierCouleur("premiereCouleur",previousMainColor); 
					}
					else{
						console.log("je set secnode");
						modifierCouleur("secondeCouleur",previousSecondColor); 
					}
		        }
		    }, 10);
			
		}
	}
}


function callbackCouleur(xhr){
	console.log(xhr.responseText);
}

function modifierCouleur(nomCouleur, couleur){
	let selects = document.getElementsByClassName(nomCouleur);
 	for(let i =0, il = selects.length;i<il;i++){
     	selects[i].setAttribute('style', 'background-color :  '+couleur+' !important');
  	}
  	selects = document.getElementsByClassName(nomCouleur+"Text");
 	for(let i =0, il = selects.length;i<il;i++){
 		selects[i].setAttribute('style', 'color : '+couleur+' !important');
 	}
  	selects = document.getElementsByClassName(nomCouleur+"Border");
 	for(let i =0, il = selects.length;i<il;i++){
 		selects[i].setAttribute('style', 'border-color :  '+couleur+' !important');
  	}
}


document.addEventListener("DOMContentLoaded", function() {
	let picker1 = document.querySelector('#colorPicker1');
	let picker2 = document.querySelector('#colorPicker2');
	//dans la page html il y a toujours ces elements en display none
	previousMainColor=window.getComputedStyle(document.getElementById("premiereCouleur")).getPropertyValue('color');
	previousSecondColor=window.getComputedStyle(document.getElementById("secondeCouleur")).getPropertyValue('color');

	let checkCouleur=false;

	createColorPicker(picker1,"premiereCouleur");
	createColorPicker(picker2,"secondeCouleur");
});

