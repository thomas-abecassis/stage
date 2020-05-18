function createColorPicker(element,variableCouleur, url){
	var picker = new Picker(element);

	picker.onChange = function(color) {
	    document.body.style.setProperty(variableCouleur,color.rgbaString); 
	};

	picker.onDone = function(color){
		requeteAJAX(url+color.rgbaString,callbackCouleur);
	}

	picker.onClose = function(color){
		requeteAJAX(url+color.rgbaString,callbackCouleur);
	}
}


function callbackCouleur(xhr){
	console.log(xhr.responseText);
}

let picker1 = document.querySelector('#colorPicker1');
let picker2 = document.querySelector('#colorPicker2');
console.log(getComputedStyle(document.documentElement).getPropertyValue('--mainColor'));
createColorPicker(picker1,"--mainColor","php/lib/changerCouleur.php?secondColor="+getComputedStyle(document.documentElement).getPropertyValue('--secondColor')+"&mainColor=");
createColorPicker(picker2,"--secondColor","php/lib/changerCouleur.php?mainColor="+getComputedStyle(document.documentElement).getPropertyValue('--mainColor')+"&secondColor=");