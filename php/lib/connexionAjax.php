<?php
		include "File.php";
		require_once File::build_path(array("model", "ModelUtilisateur.php"));
		
		session_start();
        if(ModelUtilisateur::checkPassword($_GET["login"],$_GET["mdp"])){
            $v = ModelUtilisateur::select($_GET["login"]);
            if(is_null($v->getNonce())){
                $_SESSION["login"] = $_GET["login"];
                $_SESSION["admin"] = true;
            }
            echo "true";
        }
        else{
            echo "false";
        }
?>