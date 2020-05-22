<?php

class ControllerUtility{

	public static function changerCouleur(){
		if(Session::is_admin()){

			file_put_contents(File::build_path(array("..","css","couleur.css")), ':root{
	  		--mainColor:'.$_GET['mainColor'].';
	  		--secondColor:'.$_GET['secondColor'].';
			}');
		}
	}

	public static function saveImage(){
		if(Session::is_admin()){
			move_uploaded_file( $_FILES['inputPhoto']['tmp_name'],"../../image/logo.png");
		}
	}
}

?>