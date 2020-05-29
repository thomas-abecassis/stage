document.addEventListener("DOMContentLoaded", function() {

	let submit=document.getElementById("submitForm");

	if (submit!==null){
		let minEur=document.getElementById("minEur");
		let maxEur=document.getElementById("maxEur");

		let minSurface=document.getElementById("minSurface");
		let maxSurface;
		if(minSurface!==null){
			maxSurface=document.getElementById("maxSurface");
		}

		submit.addEventListener("submit",function(event){
			if(compareElementValue(minEur, maxEur)){
				event.preventDefault();
				let notEur=document.getElementById("notifEur");
				notEur.classList.remove("displayNone");
			}
			if(minSurface!==null && compareElementValue(minSurface, maxSurface)){
				event.preventDefault();
				let notSurface=document.getElementById("notifSurface");
				notSurface.classList.remove("displayNone");
			}
		});
	}
});

function compareElementValue(elementX, elementY){
	return elementX.value && elementY.value && elementX.value > elementY.value;
}