<?php
require_once File::build_path(array("model", "ModelAlerte.php"));
require_once File::build_path(array("model", "ModelLotApprofondi.php"));
require_once File::build_path(array("model", "ModelLot.php"));
require_once File::build_path(array("model", "ModelCategorie.php"));
require_once File::build_path(array("lib", "Utility.php")); // chargement du modèle

class ControllerLotApprofondi{

    public static function searchDeepen() {
        $controller='lot'; $view='rechercheApprofondie'; $pagetitle='Recherche de biens approfondie';     //appel au modèle pour gerer la BD
        $categorieValeurs=ModelCategorie::getAllValeursCategories();
        require File::build_path(array("view", "view.php"));
    }

    public static function searchedDeepen() {
        //je créer des tableaux contenant le résultat de chaque categories contenant des checkboxs du formulaire
        $typesBien=arrayContain($_GET,"typeBien"); 
        $nombrePieces=arrayContain($_GET,"nombrePieces");

        $dataCheckBox=intInArray($_GET);

        $dataPost=array(
            "localisation" => myGet("localisation"),
            "minSurface" => myGet("minSurface"),
            "maxSurface" => myGet("maxSurface"),
            "minBudget" => myGet("minBudget"),
            "maxBudget" => myGet("maxBudget")
        );

        //j'enregistre la recherche en session pour enregistrer les alertes
        $_SESSION["dataFirst"]=$dataPost;
        $_SESSION["dataCheckBox"]=$dataCheckBox;
        
        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     
        $page=myGet("page");
        $tab_lot=ModelLotApprofondi::searchDeep($dataCheckBox,$dataPost,$page);
        $nbPage=(int)((ModelLotApprofondi::getNbLotRecherche($dataCheckBox,$dataPost,$page)-1)/15)+1;
        $lot="lotApprofondi";
        $getURL = getURLParametersWithout(array("controller","action","page"));
        require File::build_path(array("view", "view.php"));
    }

    public static function searchedDeepenAlerte() {
        //je créer des tableaux contenant le résultat de chaque categories contenant des checkboxs du formulaire
        ModelLotApprofondi::unsetSession();

        $alerte=urldecode(myGet("alerte"));
        $alerte=unserialize($alerte);

        $dataCheckBox=ModelCategorie::arrayCategorieAndValeurToId($alerte->getTabCheckBox());
        $dataPost=$alerte->getTabSimple();

        $_SESSION['dataCheckBox']=$dataCheckBox;
        $_SESSION['dataPost']=$dataPost;

        $page=1;
        $nbPage=(int)((ModelLotApprofondi::getNbLotRecherche($dataCheckBox,$dataPost,$page)-1)/15)+1;
        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     //appel au modèle pour gerer la BD
        $tab_lot=ModelLotApprofondi::searchDeep($dataCheckBox,$dataPost,$page);
        $getURL = getURLParametersWithout(array("controller","action","page"));
        $lot="lotApprofondi";
        require File::build_path(array("view", "view.php"));
    }

    public static function read(){
        $id=myGet("id");
        $lot=ModelLot::select($id);
        if($lot==false){
            $controller='lot'; $view='error'; $pagetitle='erreur';     //appel au modèle pour gerer la BD
            require File::build_path(array('view','view.php'));  //"redirige" vers la vue
        }
        else{     
            $lotApprofondi=new ModelLotApprofondi($lot);
            //$options=ControllerLotApprofondi::optionsToIcons($lotApprofondi->getCommodites()); 
            $getURL=getURLParametersWithout(array("controller", "action","id"));
            $controller='lot'; $view='details'; $pagetitle='les d\'etails';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }
}
?>