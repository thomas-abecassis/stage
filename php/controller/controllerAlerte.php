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
        $alerte=new ModelAlerte(null,$_SESSION["login"],json_encode($_SESSION["dataFirst"]),json_encode($_SESSION["typesBien"]),json_encode($_SESSION["nombrePieces"]),json_encode($_SESSION["dataCheckBox"]),"Nom par défault");
        $alerte->save();
        echo "save";
    }

    public static function delete(){
        $login=myGet('id');
        if(Session::is_user($login) || Session::is_admin()){
            Modelutilisateur::delete($login);
            $tab_v=Modelutilisateur::selectAll();
            $controller='utilisateur'; $view='deleted'; $pagetitle='supprimé';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));   
        }
        else{
            $controller='utilisateur'; $view='connect'; $pagetitle='mise à jour de utilisateur';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue  
        }

    }

    public static function update(){
        $id=myGet("id");

        if(Session::is_user($id) || Session::is_admin()){
            $v=ModelUtilisateur::select($id);
            $isUpdate=true;
            $controller='utilisateur'; $view='update'; $pagetitle='mise à jour de utilisateur';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }else{
            $controller='utilisateur'; $view='connect'; $pagetitle='mise à jour de utilisateur';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }

    }


    public static function updated(){
        if(Session::is_user(myGet('login')) || Session::is_admin()){
            $admin=0;
            if(!is_null(myGet("admin")) && Session::is_admin()){
                $admin=1;
            }
            $controller='utilisateur'; $view='updated'; $pagetitle='mise à jour de utilisateur';     //appel au modèle pour gerer la BD
            $data=array(
            "login"=>myGet('login'),
            "nom"=>myGet('nom'),
            "prenom"=>myGet('prenom'),
            "mdp"=>Security::chiffrer(myGet('mdp')),
            "admin"=>$admin
            );
            ModelUtilisateur::update($data);
            $tab_v = ModelUtilisateur::selectAll();
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
        else{
            $controller='utilisateur'; $view='connect'; $pagetitle='mise à jour de utilisateur';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }

    }
}
?>

