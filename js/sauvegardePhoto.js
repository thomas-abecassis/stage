let inputPhoto=document.getElementById("inputPhoto");
var form = document.getElementById("form");

if(inputPhoto!=null){

	inputPhoto.addEventListener('change', function(ev) {

	  oData = new FormData(form);

	  var oReq = new XMLHttpRequest();
	  oReq.open("POST", "index/Utility/saveImage/", true);
	  oReq.onload = function(oEvent) {
	      callbackPhoto(oReq);
	  };

	  oReq.send(oData);
	  ev.preventDefault();
	}, false);

	function callbackPhoto(xhr){
		console.log("coucou");
		document.location.reload();
	}
}