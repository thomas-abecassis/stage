<?php

require_once "File.php";
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

	public function creerLot($id,$ville, $surface, $loyer, $typeDeBien, $nombrePiece, $description, $informationsCommercial, $typesDePieces, $commodites, $rangements, $orientations, $options){
		if(!$this->auth){
			exit();
		}
		$sql="INSERT INTO lot (id, localisation, surface, loyer, typeDeBien, nombrePiece,description,informationsCommercial) VALUES ($id,\"$ville\", $surface, $loyer, \"$typeDeBien\", $nombrePiece,\"$description\",\"$informationsCommercial\")";
		//on enregistre le lot simple

		if(!Serv::$pdo->exec($sql)){
			return false;
		}

		$tables=array(	"typeDePiecesLot" => $typesDePieces,
						"commoditesLot" => $commodites,
						"rangementsLot" => $rangements,
						"orientationsLot" => $orientations,
						"myOptionsLot" => $options
					);
		//on ajoute toutes ses "options"
		foreach ($tables as $table => $values) {
			$sql = "insert into ". $table . " values ";
			$isFirst = true;
			foreach ($values as $value) {
				if(!$isFirst){
					$sql=$sql.", ";
				}
				$sql=$sql . "(" . $id . " , \"" . $value . "\")";
				$isFirst = false;
			}
			Serv::$pdo->exec($sql);
		}
		
		return true;
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
		$location = File::build_path(array("..","image",$id,$i.".jpg"));   // Mention where to upload the file
        $current = file_get_contents($location);                     // Get the file content. This will create an empty file if the file does not exist     
        $current = base64_decode($image);                          // Now decode the content which was sent by the client     
        file_put_contents($location, $current);                      // Write the decoded content in the file mentioned at particular location   
        return "fait";
	}

	public function supprimerImage(){
	  //foreach(glob($dir . '/*') as $file) { 
	    //if(is_dir($file)) delete_files($file); else unlink($file); 
	  //} rmdir($dir); 
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