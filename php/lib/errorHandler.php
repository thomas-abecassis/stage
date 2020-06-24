<?php

 $debug=false;
 function errorPage(){
 	ControllerErreur::erreurActionNotFound();
 }
if(!$debug){
	set_error_handler("errorPage"); 
	error_reporting(0);
}