<?php
require_once File::build_path(array("controller", "ControllerLot.php"));
require_once File::build_path(array("controller", "ControllerUtilisateur.php"));
require_once File::build_path(array("controller", "ControllerCommande.php"));
require_once File::build_path(array("controller", "ControllerLotApprofondi.php"));
require_once File::build_path(array("controller", "ControllerAlerte.php"));

 function myGet($nomvar){
 	if(isset($_GET[$nomvar])){
 		return $_GET[$nomvar];
 	}
 	if(isset($_POST[$nomvar])){
 		return $_POST[$nomvar];
 	}
 	return NULL;
 }

$action='search';
if(!is_null(myGet('action'))){
	$action = myGet('action');
}

$controller='lot';
if(!is_null(myGet('controller'))){
	$controller = myGet('controller');
}
$controller_classe="Controller".ucfirst($controller);

if(class_exists($controller_classe,false)){
	$controller_classe::$action();
}else{
	ControllerLot::error();
}


?>



	