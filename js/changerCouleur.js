function createColorPicker(element,variableCouleur){
	var picker = new Picker(element);

	picker.onChange = function(color) {
	    document.body.style.setProperty(variableCouleur,color.rgbaString); 
	};

	picker.onDone = function(color){
		let url;
		if(variableCouleur=="--mainColor"){
			url="php/lib/changerCouleur.php?secondColor="+previousSecondColor+"&mainColor="+color.rgbaString;
			previousMainColor=color.rgbaString;
		}
		else{
			url="php/lib/changerCouleur.php?secondColor="+color.rgbaString+"&mainColor="+previousMainColor;
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
		setTimeout(function () {
	        if (!checkCouleur) {
	        	if(variableCouleur=="--mainColor"){
	        		document.body.style.setProperty(variableCouleur,previousMainColor); 
				}
				else{
					document.body.style.setProperty(variableCouleur,previousSecondColor); 
				}
	        }
	    }, 10);
		
	}
}


function callbackCouleur(xhr){
	console.log(xhr.responseText);
}

document.addEventListener("DOMContentLoaded", function() {
	let picker1 = document.querySelector('#colorPicker1');
	let picker2 = document.querySelector('#colorPicker2');
	previousMainColor=getComputedStyle(document.documentElement).getPropertyValue('--mainColor');
	previousSecondColor=getComputedStyle(document.documentElement).getPropertyValue('--secondColor');

	let checkCouleur=false;

	createColorPicker(picker1,"--mainColor");
	createColorPicker(picker2,"--secondColor");
});

