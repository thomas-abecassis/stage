<?php
$DS = DIRECTORY_SEPARATOR;
require_once __DIR__.$DS."php".$DS."lib".$DS."File.php";
require_once File::build_path(array("lib", "errorHandler.php"));
session_start();
require_once File::build_path(array("lib", "Session.php"));
require_once File::build_path(array("controller", "routeur.php"));