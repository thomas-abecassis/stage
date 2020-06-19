<?php

 $debug=true;
 function errorPage(){
 	ControllerErreur::erreurActionNotFound();
 }
if(!$debug){
	set_error_handler("errorPage"); 
	error_reporting(0);
}