<?php
require_once File::build_path(array("model", "ModelAlerte.php"));
require_once File::build_path(array("model", "ModelLotApprofondi.php"));
require_once File::build_path(array("model", "ModelLot.php"));
require_once File::build_path(array("lib", "Utility.php")); // chargement du modèle

class ControllerLotApprofondi{

    public static function searchDeepen() {
        $controller='lot'; $view='rechercheApprofondie'; $pagetitle='Recherche de biens approfondie';     //appel au modèle pour gerer la BD
        $typesDeBiens=ModelLotApprofondi::getAllTypesBiens();
        $typesDePieces=ModelLotApprofondi::getAllTypesPieces();
        $commodites=ModelLotApprofondi::getAllCommodites();
        $rangements=ModelLotApprofondi::getAllTypesRangements();
        $orientations=ModelLotApprofondi::getAllOrientations();
        $options=ModelLotApprofondi::getAllOptions();
        require File::build_path(array("view", "view.php"));
    }

    public static function searchedDeepen() {
        //je créer des tableaux contenant le résultat de chaque categories contenant des checkboxs du formulaire
        var_dump($_GET);
        $typesBien=arrayContain($_GET,"typeBien"); 
        $nombrePieces=arrayContain($_GET,"nombrePieces");

        $dataCheckBox=array(
            "typeDePiecesLot"=>arrayContain($_GET,"typePiece"),
            "commoditesLot"=>arrayContain($_GET,"commodite"),
            "rangementsLot"=>arrayContain($_GET,"rangement"),
            "orientationsLot"=>arrayContain($_GET,"orientation"),
            "myOptionsLot"=>arrayContain($_GET,"myOptions")
        );
        $dataPost=array(
            "localisation" => myGet("localisation"),
            "minSurface" => myGet("minSurface"),
            "maxSurface" => myGet("maxSurface"),
            "minBudget" => myGet("minBudget"),
            "maxBudget" => myGet("maxBudget")
        );

        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     
        $page=myGet("page");
        $tab_v=ModelLotApprofondi::searchDeep($typesBien,$nombrePieces,$dataCheckBox,$dataPost,$page);
        $nbPage=(int)((ModelLotApprofondi::getNbLotRecherche($typesBien,$nombrePieces,$dataCheckBox,$dataPost,$page)-1)/15)+1;
        $lot="lotApprofondi";
        $getURL = getURLParametersWithout(array("controller","action","page"));
        require File::build_path(array("view", "view.php"));
    }

    public static function searchedDeepenAlerte() {
        //je créer des tableaux contenant le résultat de chaque categories contenant des checkboxs du formulaire
        ModelLotApprofondi::unsetSession();

        $alerte=urldecode(myGet("alerte"));
        $alerte=unserialize($alerte);
        
        $typesBien=$alerte->getTabTypesBien(); 
        $nombrePieces=$alerte->getTabNombrePieces();

        $dataCheckBox=$alerte->getTabCheckBox();
        $dataPost=$alerte->getTabSimple();

        $_SESSION['typesBien']=$typesBien;
        $_SESSION['nombrePieces']=$nombrePieces;
        $_SESSION['dataCheckBox']=$dataCheckBox;
        $_SESSION['dataPost']=$dataPost;

        $page=1;
        $nbPage=(int)((ModelLotApprofondi::getNbLotRecherche($typesBien,$nombrePieces,$dataCheckBox,$dataPost,$page)-1)/15)+1;
        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     //appel au modèle pour gerer la BD
        $tab_v=ModelLotApprofondi::searchDeep($typesBien,$nombrePieces,$dataCheckBox,$dataPost,$page);
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

    //cette fonction sert à convertir le noms des options ou des commodites vers une icone html.
    /*private static function optionToIcon($option){
        if(strcmp($option, "piscine")==0){
            return ' <i title="piscine" class="material-icons">pool</i>';
        }
        else{
            return $option;
        }
    }

    private static function optionsToIcons($options){
        for($i=0;$i<count($options);$i++){
            $options[$i]=ControllerLotApprofondi::optionToIcon($options[$i]);
        }
        return $options; 
    }*/

}
?>