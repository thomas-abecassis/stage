<?php

function arrayContain($array,$substring){
	$newArray=array();
	foreach ($array as $key => $value) {
		if(strpos($key, $substring) !==false){
			array_push($newArray, str_replace( $substring,"",$key));
		}
	}
	return $newArray;
}

?>