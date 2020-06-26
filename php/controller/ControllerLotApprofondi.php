<?php
require_once File::build_path(array("model", "ModelAlerte.php"));
require_once File::build_path(array("model", "ModelLotApprofondi.php"));
require_once File::build_path(array("model", "ModelLot.php"));
require_once File::build_path(array("model", "ModelCategories.php"));
require_once File::build_path(array("model", "ModelUtilisateur.php"));
require_once File::build_path(array("lib", "Utility.php"));

class ControllerLotApprofondi{

    public static function searchDeepen() {
        $tabTypeDeBien=array("maison");
        $controller='lot'; $view='rechercheApprofondie'; $pagetitle='Recherche de biens approfondie';     //appel au modèle pour gerer la BD
        $categorieValeurs=ModelCategories::getAllValeursCategories();
        require File::build_path(array("view", "view.php"));
    }


    public static function searchedDeepen() {
        //je créer des tableaux contenant le résultat de chaque categories contenant des checkboxs du formulaire
        $dataCheckBox=intInArray($_GET);
        $maxSurface=myGet("maxSurface");
        if(is_null($maxSurface)){
            $maxSurface="";
        }

        $dataPost=array(
            "localisation" => myGet("localisation"),
            "minSurface" => myGet("minSurface"),
            "maxSurface" => $maxSurface,
            "minBudget" => myGet("minBudget"),
            "maxBudget" => myGet("maxBudget")
        );
        ControllerLotApprofondi::searched($dataPost, $dataCheckBox);
    }

    public static function searchedDeepenAlerte() {
        ModelLotApprofondi::unsetSession();
        $alerte=urldecode(myGet("alerte"));
        $alerte=unserialize($alerte);
        if($alerte===false){
            //comme unserialize lève une notice dans le cas d'une erreur nous n'avons pas besoin de la gérer, l'errorHandler s'en charge
            return;
        }

        $tab=array();
        foreach ($alerte->getTabCheckBox() as $tabValeurCategorie) {
            $nomCategorie=$tabValeurCategorie["categorie"];
            if(array_key_exists($nomCategorie, $tab)){
                array_push($tab[$nomCategorie], $tabValeurCategorie["valeur"]);
            }else{
                $tab[$nomCategorie]=array($tabValeurCategorie["valeur"]);
            }
        }
        $dataCheckBox=ModelCategories::arrayCategorieAndValeurToId($tab);
        $dataPost=$alerte->getTabSimple();
        ControllerLotApprofondi::searched($dataPost, $dataCheckBox);
    }

    public static function read(){
        $id=myGet("id");
        $lot=ModelLot::selectById($id);
        if($lot==false){
            $controller='erreur'; $view='erreur404'; $pagetitle='Erreur 404';     //appel au modèle pour gerer la BD
            require File::build_path(array('view','view.php'));  //"redirige" vers la vue
        }
        else{     
            $lotApprofondi=new ModelLotApprofondi($lot);
            $getURL=getURLParametersWithout(array("controller", "action","id"));
            if(!is_null(myGet("alerte")))
                $retour="searchedDeepenAlerte";
            else
                $retour="searchedDeepen";
            $controller='lot'; $view='details'; $pagetitle='les d\'etails';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }

    private static function searched($dataPost, $dataCheckBox){
        $_SESSION["dataFirst"]=$dataPost;
        $_SESSION["dataCheckBox"]=$dataCheckBox;
        
        $page=myGet("page");
        if(!intval($page))
            $page=1;
        if($page<1)
            $page=1;
        $nbPage=(int)((ModelLotApprofondi::getNbLotRecherche($dataCheckBox,$dataPost)-1)/15)+1;
        if($page>$nbPage)
            $page=$nbPage;

        $tab_lot=ModelLotApprofondi::searchDeep($dataCheckBox,$dataPost,$page);
        $lot="lotApprofondi";
        $getURL = getURLParametersWithout(array("controller","action","page"));

        $controller='lot'; $view='list'; $pagetitle='Liste des lots';  
        require File::build_path(array("view", "view.php"));
    }
}
