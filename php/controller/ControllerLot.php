<?php
require_once File::build_path(array("model", "ModelLot.php"));
require_once File::build_path(array("lib", "Utility.php")); // chargement du modèle
class ControllerLot {

    public static function readAll() {
        $tab_v = ModelLot::selectAll();
        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function search() {
        $controller='lot'; $view='recherche'; $pagetitle='Recherche de biens';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    //! a refactoriser comme dans le controllerLotApprofondi  !\\
    public static function searched(){
        $page=myGet('page');
        if($page<1){
            $page=1;
        }
        if(isset($_POST["localisation"])){
            $data=array(
                "localisation" => myGet("localisation"),
                "minSurface" => myGet("minSurface"),
                "maxSurface" => myGet("maxSurface"),
                "minBudget" => myGet("minBudget"),
                "maxBudget" => myGet("maxBudget")
            );
            $_SESSION["dataFirst"]=$data;
        }else{
            $data=$_SESSION["dataFirst"];
        }
        $tab_v = ModelLot::selectByRecherche($data,$page);
        $page=(int)$page;
        $nbPage=(int)((ModelLot::getNbLotRecherche($data)-1)/15)+1;
        $lot="lot";
        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    /*(public static function Read(){
    	$v=ModelLot::select(myGet('id'));
    	if($v==false){
        $controller='lot'; $view='error'; $pagetitle='erreur';     //appel au modèle pour gerer la BD
        require File::build_path(array('view','view.php'));  //"redirige" vers la vue
    	}else{
        $controller='lot'; $view='details'; $pagetitle='les d\'etails';     //appel au modèle pour gerer la BD
        $model=$v;
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
	    }
    }*/

    public static function create(){
        $v=new ModelLot("","","");
        $isUpdate=false;
    	$controller='lot'; $view='update'; $pagetitle='creation de lot';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function created(){
    	$id=myGet('id');
    	$nom=myGet('nom');
    	$prix=myGet('prix');
 		$v=new ModelLot($id,$nom,$prix);
 		$v->save();
        $controller='lot'; $view='created'; $pagetitle='cree';     //appel au modèle pour gerer la BD
        $tab_v = ModelLot::selectAll();
        require File::build_path(array("view", "view.php"));
    }

    public static function delete(){
        $id=myGet('id');
        ModelLot::delete($id);
        $tab_v=ModelLot::selectAll();
        $controller='lot'; $view='deleted'; $pagetitle='supprimé';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));
    }

    public static function update(){
        $im=myGet('id');
        $v=ModelLot::select($im);
        $isUpdate=true;
        $controller='lot'; $view='update'; $pagetitle='mise à jour de lot';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }


    public static function updated(){
        $controller='lot'; $view='updated'; $pagetitle='mise à jour de lot';     //appel au modèle pour gerer la BD
        $data=array(
            "id"=>myGet("id"),
            "nom"=>myGet("nom"),
            "prix"=>myGet("prix")
        );
        ModelLot::update($data);
        $tab_v = ModelLot::selectAll();
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }
    public static function error(){
        $controller='lot'; $view='error'; $pagetitle='erreur';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

}
?>
