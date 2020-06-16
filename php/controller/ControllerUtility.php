<?php

//pas besoin de require le model optionsSite car il est déjà require dans le routeur

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

	public static function updateOptionSite(){
		if(Session::is_admin()){
			ModelOptionsSite::update(array("nomOption"=>$_GET['nomOption'], "valeur"=>$_GET['valeur']));
		}
	}

	public static function updateLienReseau(){
		if(Session::is_admin()){
			$lien=$_GET['valeur'];
			if(strcmp("", $lien)!==0 && strpos(strtolower($lien), "http://") === false && strpos(strtolower($lien), "https://") === false)
				//pour rediriger vers un site extérieur il faut "http://" devant le lien on vérifie donc si le client l'a rentré, dans le cas échéant on le rajoute
				$lien="http://".$lien; 
			ModelOptionsSite::update(array("nomOption"=>$_GET['nomOption'], "valeur"=>$lien));
		}
	}

	public static function activerReseauSocial(){
		if(Session::is_admin()){
			$reseau=ModelOptionsSite::select($_GET['nomOption']);
			if(is_null($reseau->getValeur())){
				ModelOptionsSite::update(array("nomOption"=>$_GET['nomOption'], "valeur"=>""));
			}
			else{
				ModelOptionsSite::update(array("nomOption"=>$_GET['nomOption'], "valeur"=> null));
			}
		}
	}
}

