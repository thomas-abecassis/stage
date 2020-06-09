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
        $u=false;
        if(Session::is_admin()){
    	   $u=ModelUtilisateur::select(myGet("id"));
        }
        else if(Session::is_connected()){
            $u=ModelUtilisateur::select($_SESSION["login"]);
        }
    	if($u!==false || (Session::is_admin()) && !$u->isSuperAdmin()){
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
        if(strlen(myGet("nom")) * strlen(myGet("prenom")) == 0){
            echo "no_null_field";
            return;
        }
        if(Session::is_admin()){
            if( !is_null(myGet("role"))){
                $role=myGet("role");
            }
        }
        else if(Session::is_connected()){
            $utilisateur=ModelUtilisateur::select($_SESSION["login"]);
            $data=array(
            "login"=>$_SESSION["login"],
            "nom"=>myGet('nom'),
            "prenom"=>myGet('prenom'),
            "mdp"=>$utilisateur->getMdp(),
            "role"=>$utilisateur->getRole()
            );
            ModelUtilisateur::update($data);
            echo "true";
        }
        else{
            echo "false";
        }
    }

    public static function updatedMailAJAX(){
        if(strlen(myGet("mdp")) * strlen(myGet("mail"))==0){
            echo "no_null_field";
            return;
        }
        if(!filter_var(myGet("mail"), FILTER_VALIDATE_EMAIL)){
            echo "mail_bad_syntax";
            return;
        }
        if((ModelUtilisateur::checkPassword($_SESSION["login"],myGet("mdp"))) || Session::is_admin()){
            if(ModelUtilisateur::select(myGet("mail"))==false){
            ModelUtilisateur::updatePrimaryKey($_SESSION["login"],myGet("mail"));
            $_SESSION["login"]=myGet("mail");
            echo "true";
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
        if(strlen(myGet("newMdp")) * strlen(myGet("oldMdp"))==0){
            echo "no_null_field";
            return;
        }
        if(Session::is_admin()){
            //todo
        }
        else if(ModelUtilisateur::checkPassword($_SESSION["login"],myGet("oldMdp"))){
            $u=ModelUtilisateur::select($_SESSION["login"]);
            $data=array(
            "login"=>$u->getLogin(),
            "nom"=>$u->getNom(),
            "prenom"=>$u->getPrenom(),
            "mdp"=>Security::chiffrer(myGet("newMdp")),
            "role"=>$u->getRole()
            );
            ModelUtilisateur::update($data);
            echo "true";
        }
        else{
            return "bad_password";
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