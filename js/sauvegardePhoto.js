let inputPhoto=document.getElementById("inputPhoto");

var form = document.getElementById("form");
form.addEventListener('submit', function(ev) {

  oData = new FormData(form);

  var oReq = new XMLHttpRequest();
  oReq.open("POST", "php/lib/saveImage.php", true);
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