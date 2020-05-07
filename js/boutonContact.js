let boutonTel=document.getElementById("contactTelButton");
let boutonMail=document.getElementById("contactMailButton");
let contenuTel=document.getElementById("contactTelContent");
let contenuMail=document.getElementById("contactMailContent");

function reveleContenu(bouton,contenu){
  bouton.classList.remove("displayFlex");
  bouton.classList.add("displayNone");
  contenu.classList.remove("displayNone");
  contenu.classList.add("displayFlex");
}


boutonTel.addEventListener("click",function(){
  reveleContenu(boutonTel,contenuTel);
});

boutonMail.addEventListener("click",function(){
  reveleContenu(boutonMail,contenuMail);
});
