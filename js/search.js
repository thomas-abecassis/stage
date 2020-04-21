let searchBox=document.getElementById("searchBoxVille");
var xhr2= new XMLHttpRequest();
	xhr2.addEventListener('readystatechange', function() { // On gère ici une requête asynchrone

    if (xhr2.readyState === XMLHttpRequest.DONE && searchBox.value.length!==0) {
	        document.getElementById('resultSearchVille').innerHTML =  xhr2.responseText ;
	        eventOnCity(); 
	    }
	});

searchBox.addEventListener("input", function(){
	search();
	if(searchBox.value.length==0){
		document.getElementById('resultSearchVille').innerHTML=null;
	}
});

function eventOnCity(){
	let children = Array.from(document.getElementById("resultSearchVille").children);
	children.forEach(function(element){
		element.addEventListener("click",()=>{searchBox.value=element.innerHTML.split("(")[0];
		document.getElementById('resultSearchVille').innerHTML=null;});
	}
	);
}


function indexHover(){
	let children = Array.from(document.getElementById("resultSearchVille").children);
	let i=0;
	let e=-1;
	children.forEach(function(element){
		if(element.classList.contains("resultWordHover")){
			e=i;
		}
		i++;
	}
	);
	return e;
}

function search(){	
	xhr2.open("get", "lib/search?mot="+searchBox.value, true);
	xhr2.send(null);
}

$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});

document.onkeydown = function (e) {
    e = e || window.event;
    let children = Array.from(document.getElementById("resultSearchVille").children);
    let ih=indexHover();
    if(children.length!=0){
	    if(ih===-1 && e.keyCode==40){
	    	children[0].classList.add("resultWordHover");
    	}	    
    	else if(e.keyCode==40 && ih!=children.length-1){
	    	children[ih+1].classList.add("resultWordHover");
	    	children[ih].classList.remove("resultWordHover");
    	}    	
    	else if(e.keyCode==38 && ih!=0){
	    	children[ih-1].classList.add("resultWordHover");
	    	children[ih].classList.remove("resultWordHover");
    	}else if(e.keyCode==13){
    	searchBox.value=children[ih].innerHTML.split("(")[0];
		document.getElementById('resultSearchVille').innerHTML=null;
    	}
	}	

};