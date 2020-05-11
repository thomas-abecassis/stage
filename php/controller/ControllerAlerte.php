<?php
require_once File::build_path(array("model", "ModelAlerte.php")); // chargement du modèle

class ControllerAlerte {

    protected static $object="alerte";

    public static function readAll() {
        $tab_v = ModelUtilisateur::selectAll();
        $controller='utilisateur'; $view='list'; $pagetitle='Liste des utilisateur';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function Read(){
        if (isset($_SESSION["login"])){
            $alertes=ModelAlerte::selectCol("loginUtilisateur",$_SESSION["login"]);
            $controller='alerte'; $view='list'; $pagetitle='vos alertes';     //appel au modèle pour gerer la BD
            require File::build_path(array("view","view.php"));   
        }else{
            echo "il faut se connecter";
        }
    }

    public static function created(){
        echo $_SESSION["login"];
        $alerte=new ModelAlerte(null,$_SESSION["login"],json_encode($_SESSION["dataFirst"]),json_encode($_SESSION["typesBien"]),json_encode($_SESSION["nombrePieces"]),json_encode($_SESSION["dataCheckBox"]),"Nom par défault",true);
        $alerte->save();
        ModelAlerte::unsetSession();
        echo "save";
    }

    public static function delete(){
        $id=myGet('id');
        $login=$_SESSION["login"];
        if((Session::is_user($login) && ModelAlerte::alerteCorrespondToUser($id,$login)) || Session::is_admin()){
            ModelAlerte::delete($id);
            echo "delete";  
        }
        else{
            echo "pas les droits";
        }

    }

    public static function update(){ //l'utilisateur peut seulement modifier le nom de sa recherche sauvegardé
        $id=myGet("id");
        $nom=myGet("nom");
        $login=$_SESSION["login"];
        if((Session::is_user($login) && ModelAlerte::alerteCorrespondToUser($id,$login)) || Session::is_admin()){
            $alerte=ModelAlerte::select($id);
            $alerte->setNom($nom);
            $alerte->updated();
            echo "enregistré";
        }else{
            echo "pas les droits";
        }

    }

}
?>

