<?php
include "File.php";
require_once File::build_path(array("config", "Conf.php"));


function getVille($str){
	$hostname=Conf::getHostName(); $database_name=Conf::getDatabase();
	$login=Conf::getLogin(); $password=Conf::getPassword();
	$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password,
                     array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $sql="SELECT * from villesFrance WHERE (lower(nom) LIKE :nom) OR CAST(codePostal as CHAR ) LIKE :nom LIMIT 5";

    $req_prep = $pdo->prepare($sql);

    $values = array(
        "nom" => $str."%",
        //nomdutag => valeur, ...
    );
  
    $req_prep->execute($values);

    // On récupère les résultats comme précédemment
    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    $tab_ville = $req_prep->fetchAll();
    // Attention, si il n'y a pas de résultats, on renvoie false
    if (empty($tab_ville)){
        return false;
      }
    return $tab_ville;
  }


$tab=getVille($_GET["mot"]);
if($tab!==false){
        echo json_encode($tab);
}
else{
    echo "false";
}



?>