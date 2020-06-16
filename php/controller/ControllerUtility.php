<?php

class ControllerUtility{

	public static function changerCouleur(){
		if(Session::is_admin()){
			file_put_contents(File::build_path(array("..","css","couleur.css")), '
				.premiereCouleur{
				  background-color:'.$_GET['mainColor'].' !important;
				}

				.premiereCouleurText{
				  color:  '.$_GET['mainColor'].' !important;
				}

				.premiereCouleurBorder{
				  border-color:  '.$_GET['mainColor'].' !important;
				}

				.secondeCouleur{
				    background-color: '.$_GET['secondColor'].' !important;
				}

				.secondeCouleurText{
				  color: '.$_GET['secondColor'].' !important
				}

				.secondeCouleurBorder{
				  border-color: '.$_GET['secondColor'].' !important
				}'
			);
		}
	}

	public static function saveImage(){
		if(Session::is_admin()){
			move_uploaded_file( $_FILES['inputPhoto']['tmp_name'],File::build_path(array("..","image",myGet("nomFichier").".png")));
			echo "save";
		}
	}

	/*private static function changeFichierTexte($fichier, $contenu){
		if(Session::is_admin()){
			$file_handle = fopen(File::build_path(array("..","fichiers",$fichier)), 'w'); 
			fwrite($file_handle, $contenu);
			fclose($file_handle);
			return true;
		}		
		return false;
	}*/

	public static function updateMail(){
		ControllerUtility::changeFichierTexte("mail.txt",$_GET['nouveauMail']);
	}

	public static function updateTel(){
		ControllerUtility::changeFichierTexte("tel.txt",$_GET['nouveauTel']);
	}

}

?>