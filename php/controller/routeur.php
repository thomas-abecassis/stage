<?php
require_once File::build_path(array("controller", "ControllerLot.php"));
require_once File::build_path(array("controller", "ControllerUtilisateur.php"));
require_once File::build_path(array("controller", "ControllerLotApprofondi.php"));
require_once File::build_path(array("controller", "ControllerAlerte.php"));
require_once File::build_path(array("controller", "ControllerUtility.php"));
require_once File::build_path(array("controller", "ControllerErreur.php"));
require_once File::build_path(array("model", "ModelOptionsSite.php"));

 function myGet($nomvar){
 	if(isset($_GET[$nomvar])){
 		return $_GET[$nomvar];
 	}
 	if(isset($_POST[$nomvar])){
 		return $_POST[$nomvar];
 	}
 	return NULL;
 }

 function getURLParametersWithout($arrayParametersNotWanted){
 	$url="&";
 	$arrayCopy=$_GET;

 	foreach ($arrayParametersNotWanted as  $valueNotWanted) {
		unset($arrayCopy[$valueNotWanted]);
 	}

 	foreach ($arrayCopy as $key => $value) {
 		$url=$url.$key."=".rawurlencode($value)."&";
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

if(class_exists($controller_classe,false) && method_exists(new $controller_classe(), $action)){
	//j'initialise ces variables ici pour qu'elles soient présentent dans toutes les vues
	$mail = ModelOptionsSite::select("mail")->getValeur();
	$tel = ModelOptionsSite::select("telephone")->getValeur();
	$facebook = ModelOptionsSite::select("facebook")->getValeur();
	$twitter = ModelOptionsSite::select("twitter")->getValeur();
	$linkedin = ModelOptionsSite::select("linkedin")->getValeur();
	$instagram = ModelOptionsSite::select("instagram")->getValeur();

	$controller_classe::$action();
}else{
	ControllerErreur::erreurActionNotFound();
}