<?php

$DS = DIRECTORY_SEPARATOR;
require_once __DIR__.$DS."lib".$DS."File.php";
require_once File::build_path(array("model", "ModelProduit.php"));
session_start();
require_once File::build_path(array("lib", "Session.php"));
require_once File::build_path(array("controller", "routeur.php"));
?>