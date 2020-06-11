<?php
require_once File::build_path(array("model", "ModelAlerte.php")); // chargement du modèle
require_once File::build_path(array("model", "ModelCategorie.php"));

class ControllerAlerte {

    public static function Read(){
        if (Session::is_connected()){
            $alertes=ModelAlerte::selectCol("loginUtilisateur",$_SESSION["login"]);
            if($alertes != false){
                foreach ($alertes as $alerte) {
                    $alerte->decode();
                }
            }
            $controller='alerte'; $view='list'; $pagetitle='vos alertes';     //appel au modèle pour gerer la BD
            require File::build_path(array("view","view.php"));   
        }else{
        $controller='lot'; $view='recherche'; $pagetitle='Recherche de biens';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }   
    }

    public static function created(){
        if(Session::is_connected() && !empty($_SESSION["dataFirst"])){
            $alerte=new ModelAlerte(null,$_SESSION["login"],$_SESSION["dataFirst"],ModelCategorie::arrayIdToValeurAndCategorie($_SESSION["dataCheckBox"]),"Nom par défault",true);
            $alerte->encode();
            $alerte->save();
            ModelAlerte::unsetSession();
            echo "save";
        }
        else{
            $controller='lot'; $view='recherche'; $pagetitle='Recherche de biens';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }

    public static function deleteAJAX(){
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

    public static function activeAJAX(){
        $id=myGet("id");
        $login=$_SESSION["login"];
        if((Session::is_user($login) && ModelAlerte::alerteCorrespondToUser($id,$login)) || Session::is_admin()){
            $alerte=ModelAlerte::select($id);
            $alerte->setActiveMail(!$alerte->getActiveMail());
            var_dump($alerte->getActiveMail());
            var_dump(!$alerte->getActiveMail());
            $alerte->updated();
            echo "enregistré";
        }else{
            echo "pas les droits";
        }
    }
}
?>