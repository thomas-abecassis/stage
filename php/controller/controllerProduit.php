<?php
require_once File::build_path(array("model", "ModelProduit.php"));
require_once File::build_path(array("lib", "Utility.php")); // chargement du modèle
class ControllerProduit {

    protected static $object="produit";

    public static function readAll() {
        $tab_v = ModelProduit::selectAll();
        $controller='produit'; $view='list'; $pagetitle='Liste des produits';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function search() {
        $controller='produit'; $view='recherche'; $pagetitle='Recherche de biens';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function searched(){
        ControllerProduit::search();
    }


    public static function searchDeepen() {
        $controller='produit'; $view='rechercheApprofondie'; $pagetitle='Recherche de biens approfondie';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function searchedDeepen() {
        //je créer des tableaux contenant le résultat de chaque categories contenant des checkboxs du formulaire
        $typesBien=arrayContain($_POST,"typeBien"); $nombreChambre=arrayContain($_POST,"nombreChambre"); 
        $nombrePieces=arrayContain($_POST,"nombrePieces"); $typePiece=arrayContain($_POST,"typePiece");
        $commodite=arrayContain($_POST,"commodite"); $rangement=arrayContain($_POST,"rangement");
        $orientation=arrayContain($_POST,"orientation"); $options=arrayContain($_POST,"options");
        ControllerProduit::search();
    }

    public static function Read(){
    	$v=ModelProduit::select(myGet('id'));
    	if($v==false){
        $controller='produit'; $view='error'; $pagetitle='erreur';     //appel au modèle pour gerer la BD
        require File::build_path('view/view.php');  //"redirige" vers la vue
    	}else{      
        $controller='produit'; $view='details'; $pagetitle='les d\'etails';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
	    }
    }

    public static function create(){
        $v=new ModelProduit("","","");
        $isUpdate=false;
    	$controller='produit'; $view='update'; $pagetitle='creation de produit';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function created(){
    	$id=myGet('id');
    	$nom=myGet('nom');
    	$prix=myGet('prix');
 		$v=new ModelProduit($id,$nom,$prix);
 		$v->save();
        $controller='produit'; $view='created'; $pagetitle='cree';     //appel au modèle pour gerer la BD
        $tab_v = ModelProduit::selectAll();
        require File::build_path(array("view", "view.php"));  
    }

    public static function delete(){
        $id=myGet('id');
        ModelProduit::delete($id);
        $tab_v=ModelProduit::selectAll();
        $controller='produit'; $view='deleted'; $pagetitle='supprimé';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  
    }

    public static function update(){
        $im=myGet('id');
        $v=ModelProduit::select($im);
        $isUpdate=true;
        $controller='produit'; $view='update'; $pagetitle='mise à jour de produit';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }


    public static function updated(){
        $controller='produit'; $view='updated'; $pagetitle='mise à jour de produit';     //appel au modèle pour gerer la BD
        $data=array(
            "id"=>myGet("id"),
            "nom"=>myGet("nom"),
            "prix"=>myGet("prix")
        );
        ModelProduit::update($data);
        $tab_v = ModelProduit::selectAll();
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function panier(){
        if(!isset($_SESSION["panier"])){
            $_SESSION["panier"]=array();
        }

        $produit= ModelProduit::select(myGet('id'));

        array_push($_SESSION["panier"],$produit);

        $tab_v=ModelProduit::selectAll();

        $controller='produit'; $view='list'; $pagetitle='acceuil';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function error(){
        $controller='produit'; $view='error'; $pagetitle='erreur';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue        
    }

}
?>

