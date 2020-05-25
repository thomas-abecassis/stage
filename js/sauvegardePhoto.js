let inputPhoto=document.getElementById("inputPhoto");
var form = document.getElementById("form");

if(form!=null){

	form.addEventListener('submit', function(ev) {

	  oData = new FormData(form);

	  var oReq = new XMLHttpRequest();
	  oReq.open("POST", "index/Utility/saveImage/", true);
	  oReq.onload = function(oEvent) {
	    if (oReq.status == 200) {
	      callbackPhoto(oReq);
	    } else {
	      callbackPhoto(oReq);
	    }
	  };

	  oReq.send(oData);
	  ev.preventDefault();
	}, false);

	function callbackPhoto(xhr){
		console.log(xhr.responseText);
	}
}