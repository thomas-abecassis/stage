let inputPhotoLogo=document.getElementById("inputPhotoLogo");
var formLogo = document.getElementById("formLogo");
let inputPhotoBanniere=document.getElementById("inputPhotoBanniere");
var formBanniere = document.getElementById("formBanniere");

if(inputPhotoLogo!=null){
	inputPhotoLogo.addEventListener('change', function() {
		modifieImage(this,document.getElementById("logo"));
	});

	formLogo.addEventListener('submit', function(ev) {
		ev.preventDefault();
		metAJourImage(ev,formLogo,"logo");
	});

	inputPhotoBanniere.addEventListener('change', function() {
		modifieImageStyle(this,document.getElementById("banniere"));
	});

	formBanniere.addEventListener('submit', function(ev) {
		ev.preventDefault();
		metAJourImage(ev,formBanniere,"banniere");
	});
}

function modifieImage(input,element){
	element.src=window.URL.createObjectURL(input.files[0]);
}

function modifieImageStyle(input,element){
	element.style.backgroundImage = "url('" + window.URL.createObjectURL(input.files[0]) + "')";
}

function metAJourImage(ev,form,nomFichier){
	oData = new FormData(form);
	oData.append("nomFichier", nomFichier);
	var oReq = new XMLHttpRequest();
	oReq.open("POST", "index/Utility/saveImage/", true);
	oReq.onload = function(oEvent) {
	    callbackPhoto(oReq);
	};
	oReq.send(oData);
}

function callbackPhoto(xhr){
	document.location.reload(true);
}