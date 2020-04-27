<?php
require_once File::build_path(array("model", "ModelLotApprofondi.php"));
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
        $typesBien=arrayContain($_POST,"typeBien");         //$nombreChambre=arrayContain($_POST,"nombreChambre"); 
        $nombrePieces=arrayContain($_POST,"nombrePieces");  //$typePiece=arrayContain($_POST,"typePiece");
        //$commodite=arrayContain($_POST,"commodite");        //$rangement=arrayContain($_POST,"rangement");
        //$orientation=arrayContain($_POST,"orientation");    //$options=arrayContain($_POST,"options");
        $dataCheckBox=array(
            "typeDePiecesLot"=>arrayContain($_POST,"typePiece"),
            "commoditesLot"=>arrayContain($_POST,"commodite"),
            "rangementsLot"=>arrayContain($_POST,"rangement"),
            "orientationsLot"=>arrayContain($_POST,"orientation"),
            "myOptionsLot"=>arrayContain($_POST,"myOptions")
        );

        $dataPost=array(
            "localisation" => myGet("localisation"),
            "minSurface" => myGet("minSurface"),
            "minBudget" => myGet("minBudget"),
            "maxBudget" => myGet("maxBudget")
        );

        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     //appel au modèle pour gerer la BD
        $tab_v=ModelLotApprofondi::searchDeep($typesBien,$nombrePieces,$dataCheckBox,$dataPost);
        require File::build_path(array("view", "view.php"));
    }

}
?>

