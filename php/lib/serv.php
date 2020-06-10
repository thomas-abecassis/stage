<?php

require_once "File.php";
require_once File::build_path(array("model","ModelLot.php"));
require_once File::build_path(array("model","ModelCategorie.php"));

class Serv{

	public static $pdo;

    public static $hostname = 'webinfo.iutmontp.univ-montp2.fr';
    public static $database_name = 'abecassist';
    public static $login = 'abecassist';
    public static $password = 'iutthomas2019';

    private $auth = false;


	public static function Init(){
		$hostname=Serv::$hostname;
		$database_name=Serv::$database_name;
		try {
			self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", Serv::$login, Serv::$password,
                     array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));		}
        catch (PDOException $e) {
			echo $e->getMessage(); // affiche un message d'erreur
			die();
		}
		self::$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}


	public function authentification($obj){
		if(strcmp($obj->login, "test") == 0 && strcmp($obj->password, "toast") == 0){
			$this->auth = true;
		}
		else{
			return "mauvais login et mdp";
		}
	}

	public function creerLot($id,$ville, $surface, $loyer, $typeDeBien, $nombrePiece, $description, $informationsCommercial, $plus){
		if(!$this->auth){
			exit();
		}

		$test=new ModelLot($id,$ville, $surface, $loyer, $description, $informationsCommercial);
		$test->save();
		//on ajoute toutes ses "options"

		//on transforme les stdClass en tableau
		$plusTab=array();
		foreach ($plus as $value) {
			$tabTemp=array();
			$tabTemp["categorie"]=$value->categorie;
			$tabTemp["valeur"]=$value->valeur;
			array_push($plusTab, $tabTemp);
		}

		$tabIdValeurs=ModelCategorie::arrayCategorieAndValeurToId($plusTab);
		foreach ($tabIdValeurs as $idValeur) {
			$sql="insert into lotCategorie values (\"$id\", $idValeur)";
			Serv::$pdo->exec($sql);
		}
		return "fait";
	}

	public function saveImage($id,$image){
		if(!$this->auth){
			return "pas connecté";
		}
		if (!file_exists(File::build_path(array("..","image",$id)))) {
		    mkdir(File::build_path(array("..","image",$id)), 0777, true);
		}
		$i=1;
		while(file_exists(File::build_path(array("..","image",$id,$i.".jpg")))){
			$i++;
		}
		$location = File::build_path(array("..","image",$id,$i.".jpg"));
        $current = file_get_contents($location);  
        $current = base64_decode($image);   
        file_put_contents($location, $current);
        return "fait";
	}

	public function supprimerImages(){
		$files = glob(File::build_path(array("..","image","*"))); 
		foreach($files as $file){ 
			if(is_file($file)){
		    unlink($file);
		    }
		    else{
		    	//dans les dossiers images de lots il n'y a pas d'autres dossiers, en partant de ce principte il n'est pas nécessaire de faire de la récursivité
		    	$filesInDir=glob(File::build_path(array("..","image",basename($file),"*")));
		    	foreach ($filesInDir as $fileInDir) {
		    		$test=$test.$fileInDir;
		    		unlink($fileInDir);
		    	}
		    	rmdir($file);
		    }
		}
		return "fait";
	}

	public function supprimeLots(){
		if(!$this->auth){
			return "pas connecté";
		}
		$sql="delete from lot";
		Serv::$pdo->exec($sql);
		return "fait";
	}
}

Serv::init();
$test=new Serv();
?>