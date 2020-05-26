let inputPhoto=document.getElementById("inputPhoto");
var form = document.getElementById("form");

if(inputPhoto!=null){

	inputPhoto.addEventListener('change', function() {
	  document.getElementById("logo").src=window.URL.createObjectURL(this.files[0]);
	});

	form.addEventListener('submit', function(ev) {
	  oData = new FormData(form);
	  var oReq = new XMLHttpRequest();
	  oReq.open("POST", "index/Utility/saveImage/", true);
	  oReq.onload = function(oEvent) {
	      callbackPhoto(oReq);
	  };
	  oReq.send(oData);
	  ev.preventDefault();
	});
}

function callbackPhoto(xhr){
	document.location.reload(true);
}