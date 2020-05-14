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
        ModelLotApprofondi::unsetSession();

        $typesBien=arrayContain($_POST,"typeBien"); 
        $nombrePieces=arrayContain($_POST,"nombrePieces");

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
            "maxSurface" => myGet("maxSurface"),
            "minBudget" => myGet("minBudget"),
            "maxBudget" => myGet("maxBudget")
        );

        $_SESSION['typesBien']=$typesBien;
        $_SESSION['nombrePieces']=$nombrePieces;
        $_SESSION['dataCheckBox']=$dataCheckBox;
        $_SESSION['dataPost']=$dataPost;


        $controller='lot'; $view='list'; $pagetitle='Liste des lots';     
        $page=myGet("page");
        $tab_v=ModelLotApprofondi::searchDeep($typesBien,$nombrePieces,$dataCheckBox,$dataPost,$page);
        ModelLotApprofondi::setSession($typesBien,$nombrePieces,$dataCheckBox);
        $nbPage=(int)((ModelLotApprofondi::getNbLotRecherche($typesBien,$nombrePieces,$dataCheckBox,$dataPost,$page)-1)/15)+1;
        $lot="lotApprofondi";
        require File::build_path(array("view", "view.php"));
    }

        public static function searchedDeepenPage() {
        //j'appelle cette fonction quand l'utilisateur parcours les différentes pages d'une recherche.
        //Les données de recherches ont été préalablement enregistré dans la session.
        $controller='lot'; $view='list'; $pagetitle='Liste des lots';    
        $page=myGet("page");
        $tab_v=ModelLotApprofondi::searchDeep($_SESSION["typesBien"],$_SESSION["nombrePieces"],$_SESSION["dataCheckBox"],$_SESSION["dataPost"],myGet("page"));
        $nbPage=(int)((ModelLotApprofondi::getNbLotRecherche($_SESSION["typesBien"],$_SESSION["nombrePieces"],$_SESSION["dataCheckBox"],$_SESSION["dataPost"],myGet("page"))-1)/15)+1;
        $lot="lotApprofondi";
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
            $controller='lot'; $view='details'; $pagetitle='les d\'etails';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }

}
?>