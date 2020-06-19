<?php

class ControllerErreur{

    public static function erreur404() {
        $controller='erreur'; $view='erreur404'; $pagetitle='Erreur 404';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }

    public static function erreurActionNotFound(){
        $controller='erreur'; $view='erreurAction'; $pagetitle='Erreur';     //appel au modèle pour gerer la BD
        require File::build_path(array("view", "view.php"));  //"redirige" vers la vue
    }
}
