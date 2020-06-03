<?php
require_once File::build_path(array("model", "ModelUtilisateur.php")); // chargement du modèle
require_once File::build_path(array("lib", "Security.php"));
class ControllerUtilisateur {

    protected static $object="utilisateur";

    public static function readAll() {
        if(Session::is_admin()){
            $tab_v = ModelUtilisateur::selectAll();
            $controller='utilisateur'; $view='list'; $pagetitle='Liste des utilisateur';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }else{
            $controller='lot'; $view='recherche'; $pagetitle='acceuil';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }

    public static function Read(){
    	$u=ModelUtilisateur::select($_GET['id']);
    	if(isset($_SESSION["login"]) && ($u->getLogin()==$_SESSION["login"] || Session::is_admin())){
            $controller='utilisateur'; $view='details'; $pagetitle='les d\'etails';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue

    	}else{      
            $controller='lot'; $view='recherche'; $pagetitle='recherche lot';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
	    }
    }


    public static function createdAjax(){
        $login=myGet('login');
        $nom=myGet('nom');
        $prenom=myGet('prenom');
        $mdp=myGet('mdp');
        if(!filter_var($login, FILTER_VALIDATE_EMAIL)){
            $v=new ModelUtilisateur("","","","","","");
            $isUpdate=false;
            echo "bad_mail_syntax";
        }else{
            $random=Security::generateRandomHex();
            if(ModelUtilisateur::select($login)!==false){
                echo "mail_allready_taken";
                return;
            }
            else{
                $v=new Modelutilisateur($login,$nom,$prenom,Security::chiffrer($mdp),0,$random);
                $v->save();
                $mail="http://webinfo.iutmontp.univ-montp2.fr/~abecassist/PHP/TD8/index.php?action=validate&controller=utilisateur&nonce=".$random."&login=".$v->getLogin();
                mail($login,"activation de votre compte",$mail);
                echo "register";
            }
        }
    }

    public static function delete(){
        $login=myGet('id');
        if(Session::is_user($login) || Session::is_admin()){
            Modelutilisateur::delete($login);
            $tab_v=Modelutilisateur::selectAll();
            if(Session::is_user($login)){
                unset($_SESSION["login"]);
            }
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


    public static function updatedAJAX(){
        if(Session::is_user(myGet('login')) || Session::is_admin()){
            $utilisateur=ModelUtilisateur::select(myGet('login'));
            if(Session::is_admin() && !is_null(myGet("role"))){
                $role=myGet("role");
            }
            else{
                $role=$utilisateur->getRole();
            }
            $data=array(
            "login"=>myGet('login'),
            "nom"=>myGet('nom'),
            "prenom"=>myGet('prenom'),
            "mdp"=>$utilisateur->getMdp(),
            "role"=>$role
            );
            ModelUtilisateur::update($data);
            $tab_v = ModelUtilisateur::selectAll();
            echo $role;
        }
        else{
            echo "false";
        }

    }

    public static function error(){
        $controller='utilisateur'; $view='error'; $pagetitle='erreur';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue        
    }

    static function connectedAjax(){
        if(ModelUtilisateur::checkPassword(myGet("login"),myGet("mdp"))){
            $v = ModelUtilisateur::select(myGet("login"));
            if(is_null($v->getNonce())){
                $_SESSION["login"] = myGet("login");
                echo("true");
                if($v->isSuperAdmin()){
                    $_SESSION["role"]=3;
                }
                if($v->isAdmin()){
                    $_SESSION["role"]=2;
                }
                if($v->isCommercial()){
                    $_SESSION["role"]=1;
                }
            }
        }
        else{
        $controller='lot'; $view='recherche'; $pagetitle='Recherche de biens';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }

    static function disconnectAjax(){
        session_unset();
        session_destroy();
        echo "true";
    }

    static function validate(){
        $u=ModelUtilisateur::select(myGet("login"));
        if($u!=false){
            $u->setNonce();
            ModelUtilisateur::update($u->getTab());
        }
    }
}
?>