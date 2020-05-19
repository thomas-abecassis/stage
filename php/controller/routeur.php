<?php
require_once File::build_path(array("controller", "ControllerLot.php"));
require_once File::build_path(array("controller", "ControllerUtilisateur.php"));
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

 function getParameters(){
 	$url="&";
 	foreach ($_GET as $key => $value) {
 		if(strcmp($key, "controller")!==0 && strcmp($key, "action")!==0 && strcmp($key, "page")!==0){
 			$url=$url.$key."=".$value."&";
 		}
 	}
 	return $url;
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