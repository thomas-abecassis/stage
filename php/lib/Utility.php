<?php

function arrayContain($array,$substring){
	$newArray=array();
	foreach ($array as $key => $value) {
		if(strpos($key, $substring) !==false){
			$nom=str_replace( $substring,"",$key);
			$nom=str_replace("_"," ",$nom);
			array_push($newArray, $nom);
		}
	}
	return $newArray;
}

function intInArray($array){
	$ar=array();
	foreach ($array as $key => $value) {
		if(is_int($key)){
			array_push($ar, $key);
		}
	}
	return $ar;
}

?>