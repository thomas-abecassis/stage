<?php

require_once "File.php";
class Serv{

	public static $pdo;

    public static $hostname = 'webinfo.iutmontp.univ-montp2.fr';
    public static $database_name = 'abecassist';
    public static $login = 'abecassist';
    public static $password = 'iutthomas2019';


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


	public function coucou(){
		return "cucouc";
	}

	public function creerLot($id, $ville, $surface, $loyer, $typeDeBien, $nombrePiece, $description, $informationsCommercial, $typesDePieces, $commodites, $rangements, $orientations, $options){
		$sql="INSERT INTO lot (id, localisation, surface, loyer, typeDeBien, nombrePiece,description,informationsCommercial) VALUES ($id,\"$ville\", $surface, $loyer, \"$typeDeBien\", $nombrePiece,\"$description\",\"$informationsCommercial\")";
		//on enregistre le lot simple
		Serv::$pdo->exec($sql);

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
		
		return "fait";
	}

	public function saveImage($id, $image){

	}
}

Serv::init();
$test=new Serv();
?>