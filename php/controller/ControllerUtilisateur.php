<?php
require_once File::build_path(array("model", "ModelUtilisateur.php")); // chargement du modèle
require_once File::build_path(array("lib", "Security.php"));
class ControllerUtilisateur {

    protected static $object="utilisateur";

    public static function readAll() {
        if(Session::is_admin()){
            $page=(int)myGet("page");
            if($page<1){
                $page=1;
            }
            $nbPage=(int)((ModelUtilisateur::count()-1)/30)+1;;
            $tab_v = ModelUtilisateur::selectAllByPage($page);
            $controller='utilisateur'; $view='list'; $pagetitle='Liste des utilisateur';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }else{
            $controller='lot'; $view='recherche'; $pagetitle='acceuil';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }

    public static function readByName() {
        if(Session::is_admin()){
            $page=(int)myGet("page");
            if($page<1){
                $page=1;
            }
            $login=myGet("login");
            $nbPage=(int)((ModelUtilisateur::countByName($login)-1)/30)+1;;
            $tab_v = ModelUtilisateur::selectByLoginAndPage($login,$page);
            $controller='utilisateur'; $view='list'; $pagetitle='Liste des utilisateur';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }else{
            $controller='lot'; $view='recherche'; $pagetitle='acceuil';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
        }
    }

    public static function Read(){
        $_SESSION["pageName"]=myGet("id");
        $u=false;
        if(Session::is_admin()){
    	   $u=ModelUtilisateur::select(myGet("id"));
        }
        else if(Session::is_connected()){
            $u=ModelUtilisateur::select($_SESSION["login"]);
        }
    	if($u!==false || (Session::is_admin()) && ($u!==false && !$u->isSuperAdmin())){
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
            $v=new ModelUtilisateur("","","","","", "");
            $isUpdate=false;
            echo "bad_mail_syntax";
        }else{
            if(ModelUtilisateur::select($login)!==false){
                echo "mail_allready_taken";
            }
            else{
                $v=new Modelutilisateur($login,$nom,$prenom,Security::chiffrer($mdp),0, date("Y-m-d H:i:s"));
                $v->save();
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
            $controller='lot'; $view='recherche'; $pagetitle='recherche de lots';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));   
        }
        else{
            $controller='lot'; $view='recherche'; $pagetitle='recherche de lots';     //appel au modèle pour gerer la BD
            require File::build_path(array("view", "view.php"));
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
        if(strlen(myGet("nom")) * strlen(myGet("prenom")) == 0){
            echo "no_null_field";
            return;
        }

        else if(Session::is_connected()){
            $roleChanged=false;
            if(Session::is_admin() && $_SESSION["login"]!==$_SESSION["pageName"]){
                $utilisateur=ModelUtilisateur::select(myGet("login"));
                if(!$utilisateur->isAdmin() || Session::is_super_admin()){
                    $role=myGet("role");
                    if(is_null($role)){
                        $role=$utilisateur->getRole();
                    }else{
                        $roleChanged=true;
                    }
                }
                else{
                    $role=$utilisateur->getRole();
                }
            }
            else{
                $utilisateur=ModelUtilisateur::select($_SESSION["login"]);
                $role=$utilisateur->getRole();
            }
            $data=array(
            "login"=>$utilisateur->getLogin(),
            "nom"=>myGet('nom'),
            "prenom"=>myGet('prenom'),
            "mdp"=>$utilisateur->getMdp(),
            "role"=>$role,
            "dateDerniereConnexion" =>$utilisateur->getDate() 
            );
            ModelUtilisateur::update($data);
            if($roleChanged){
                echo $role;
            }
            else{
                echo "true";
            }
        }

        else{
            echo "false";
        }
    }

    public static function updatedMailAJAX(){
        if(Session::is_admin() && $_SESSION["login"]!==$_SESSION["pageName"]){ //on vérifie que l'admin n'est pas sur sa propre page en vérifiant oldMail

            if(ModelUtilisateur::select(myGet("oldMail"))->isAdmin() && !Session::is_super_admin()){
                //un admin ne doit pas pouvoir modifier le mail d'un autre admin A PART dans le cas du super admin
                return;
            }

            if(strlen(myGet("mail"))==0){
                echo "no_null_field";
                return;
            }
            if(ModelUtilisateur::select(myGet("mail"))!==false) {
                echo "mail_allready_taken";
                return;
            }
            ModelUtilisateur::updatePrimaryKey(myGet("oldMail"),myGet("mail"));
            echo "trueMail".myGet("mail");
            return;

        }

        if(strlen(myGet("mdp")) * strlen(myGet("mail"))==0){
            echo "no_null_field";
            return;
        }

        if(!filter_var(myGet("mail"), FILTER_VALIDATE_EMAIL)){
            echo "mail_bad_syntax";
            return;
        }

        if((ModelUtilisateur::checkPassword($_SESSION["login"],myGet("mdp")))){
            if(ModelUtilisateur::select(myGet("mail"))==false){
                ModelUtilisateur::updatePrimaryKey($_SESSION["login"],myGet("mail"));
                $_SESSION["login"]=myGet("mail");
                $_SESSION["pageName"]=myGet("mail");
                echo "trueMail".myGet("mail");
            }
            else{
                echo "mail_allready_taken";
            }
        }
        else{
            echo "bad_password";
        }
    } 

    public static function updatedMdpAJAX(){
        if(Session::is_admin() && $_SESSION["login"]!==$_SESSION["pageName"]){

            if(strlen(myGet("newMdp"))==0){
                echo "no_null_field";
                return;
            }

            $u=ModelUtilisateur::select(myGet("oldMail"));

            if($u->isAdmin() && !Session::is_super_admin()){
                //un admin ne doit pas pouvoir modifier le mot de passe d'un autre admin A PART dans le cas du super admin
                return;
            }

            $data=array(
            "login"=>$u->getLogin(),
            "nom"=>$u->getNom(),
            "prenom"=>$u->getPrenom(),
            "mdp"=>Security::chiffrer(myGet("newMdp")),
            "role"=>$u->getRole(),
            "dateDerniereConnexion" =>$utilisateur->getDate()
            );
            ModelUtilisateur::update($data);
            echo "true";
            return;
        }

        if(strlen(myGet("newMdp")) * strlen(myGet("oldMdp"))==0){
            echo "no_null_field";
            return;
        }

        else if(ModelUtilisateur::checkPassword($_SESSION["login"],myGet("oldMdp"))){
            $u=ModelUtilisateur::select($_SESSION["login"]);
            $data=array(
            "login"=>$u->getLogin(),
            "nom"=>$u->getNom(),
            "prenom"=>$u->getPrenom(),
            "mdp"=>Security::chiffrer(myGet("newMdp")),
            "role"=>$u->getRole(),
            "dateDerniereConnexion" =>$utilisateur->getDate() 
            );
            ModelUtilisateur::update($data);
            echo "true";
        }

        else{
            echo "bad_password";
        }
    }   

    static function connectedAjax(){
        if(ModelUtilisateur::checkPassword(myGet("login"),myGet("mdp"))){
            $u = ModelUtilisateur::select(myGet("login"));
            $data=array(
            "login"=>$u->getLogin(),
            "nom"=>$u->getNom(),
            "prenom"=>$u->getPrenom(),
            "mdp"=>$u->getMdp(),
            "role"=>$u->getRole(),
            "dateDerniereConnexion" =>date("Y-m-d H:i:s") 
            );
            ModelUtilisateur::update($data);
            $_SESSION["login"] = myGet("login");
            echo "true";
            if($u->isSuperAdmin()){
                $_SESSION["role"]=3;
            }
            if($u->isAdmin()){
                $_SESSION["role"]=2;
            }
            if($u->isCommercial()){
                $_SESSION["role"]=1;
            }
            
        }
        else{
            echo "false";
        }
    }

    static function disconnectAjax(){
        session_unset();
        session_destroy();
        echo "true";
    }
}