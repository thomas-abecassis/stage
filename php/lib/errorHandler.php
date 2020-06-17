<?php
 $debug=true;
 function errorPage(){
    $controller='lot'; $view='error'; $pagetitle='Recherche de biens';     //appel au modèle pour gerer la BD
    require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
 }
if(!$debug){
	set_error_handler("errorPage"); 
	error_reporting(0);
}