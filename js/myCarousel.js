let children = Array.from(document.getElementById("slideImage").children);
let deplacement=0;
let btnSlide = document.getElementsByClassName("boutonSlider");
let imageBtnSlide = document.getElementsByClassName("ImageBoutonSlide");

function slide(){
	let slider=document.getElementById("slideImage");
	slider.style["transform"]="translate3d("+ -deplacement*100 +"%, 0px, 0px)";
	ajoutClasseSelection();
}

function ajoutClasseSelection(){
	if(imageBtnSlide.item(deplacement)!=null){
		imageBtnSlide.item(deplacement).classList.add("selectionne");
	}
}

function enleveClasseSelection(){
	if(imageBtnSlide.item(deplacement)!=null){
		imageBtnSlide.item(deplacement).classList.remove("selectionne");
	}
}

function indexEnfant(child){
	return Array.from(child.parentNode.children).indexOf(child); 
}

function deplacementDesBoutons(offset,forcePass){
	let sliderBouton=document.getElementById("slideBouton");
	if(forcePass){
		sliderBouton.style["transform"]="translate3d("+ -(Math.trunc(deplacement/3))*100 +"%, 0px, 0px)";
	}
	else if(deplacement % 3 ==(offset)){
		sliderBouton.style["transform"]="translate3d("+ -(deplacement-offset)*(1/3)*100 +"%, 0px, 0px)";
	}
}

function eventsBoutonsDroit(){
	let boutonDroit=document.getElementById("boutonDroite");
	boutonDroit.addEventListener("click",function(){
	enleveClasseSelection()
	if(deplacement<children.length-1){
		deplacement++;
	}else{
		deplacement=0;
	}
	deplacementDesBoutons(0,false);
	slide();
});
}

function eventsBoutonsGauche(){
	let boutonGauche=document.getElementById("boutonGauche");
	boutonGauche.addEventListener("click",function(){
	enleveClasseSelection()
	if(deplacement>0){
		deplacement--;
		deplacementDesBoutons(2,false);
	}else{
		deplacement=children.length-1;
		deplacementDesBoutons(1,true);
	}

	slide();
});
}

function eventsBoutonsBas(){
for (let i = 0; i < btnSlide.length; i++) {
   btnSlide.item(i).addEventListener("click",()=>{
   	enleveClasseSelection()
   	deplacement=indexEnfant(btnSlide.item(i))%3-deplacement%3+deplacement;
   	slide();
   });}
}

eventsBoutonsDroit();
eventsBoutonsGauche();
eventsBoutonsBas();