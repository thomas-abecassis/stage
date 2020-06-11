let arrayId=[];
let nomsLots=[];
document.addEventListener("DOMContentLoaded", function() {
	nomsLots = document.getElementsByClassName("nomLot");
	for (let i = 0; i < nomsLots.length; i++) {
		arrayId.push(nomsLots[i].id);
	}
	requeteAJAX("index/lotApprofondi/getNomLotsAJax/?idLots="+JSON.stringify(arrayId),function(xhr){
		setNom(xhr);
	});
});

function setNom(xhr){
	let tabLoad= document.getElementsByClassName("progress");
	console.log(tabLoad);
	while(tabLoad.length) {
		tabLoad[0].parentNode.removeChild(tabLoad[0]);
	}

	let tabNoms=JSON.parse(xhr.responseText);
	for (let i = 0; i < nomsLots.length; i++) {
		nomsLots[i].innerHTML="vente " +tabNoms[i];
	}
}


