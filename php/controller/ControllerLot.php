<?php
require_once File::build_path(array("model", "ModelLot.php"));
require_once File::build_path(array("lib", "Utility.php")); // chargement du modèle
class ControllerLot {

    public static function readAll() {
        $tab_lot = ModelLot::selectAll();
        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function search() {
        $controller='lot'; $view='recherche'; $pagetitle='Recherche de biens';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    //! a refactoriser comme dans le controllerLotApprofondi  !\\
    public static function searched(){
        $page=(int)myGet('page');
        if($page<1){
            $page=1;
        }
        $data=array(
            "localisation" => rawurldecode(myGet("localisation")),
            "minSurface" => myGet("minSurface"),
            "maxSurface" => myGet("maxSurface"),
            "minBudget" => myGet("minBudget"),
            "maxBudget" => myGet("maxBudget")
        );

        //j'enregistre la recherche en session pour enregistrer les alertes
        $_SESSION["dataFirst"]=$data;
        $_SESSION["typesBien"]=array();
        $_SESSION["nombrePieces"]=array();
        $_SESSION["dataCheckBox"]=array();

        $tab_lot = ModelLot::selectByRecherche($data,$page);
       
        $nbPage=(int)((ModelLot::getNbLotRecherche($data)-1)/15)+1;
        $lot="lot";
        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     //appel au modèle pour gerer la BD
        $getURL=getURLParametersWithout(array("controller","action","page"));
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function delete(){
        $id=myGet('id');
        ModelLot::delete($id);
        $tab_lot=ModelLot::selectAll();
        $controller='lot'; $view='deleted'; $pagetitle='supprimé';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));
    }

  
    public static function error(){
        $controller='lot'; $view='error'; $pagetitle='erreur';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

}
?>
