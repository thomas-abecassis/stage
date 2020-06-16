<?php

require_once "File.php";
require_once File::build_path(array("model","ModelLot.php"));
require_once File::build_path(array("model","ModelCategories.php"));
require_once File::build_path(array("model","ModelAlerte.php"));

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
			return "pas connecté";
		}

		$test=new ModelLot($id,$ville, $surface, $loyer, $description, $informationsCommercial, $typeDeBien, $nombrePiece);
		$villeId=$test->getLocalisationId();
		if(is_null($villeId)){
			return "nom_de_ville_inconnu";
		}
		$test->setLocalisation($villeId); //On stoque l'ID de la ville dans la table lot 
		$retSave=$test->save();
		if($retSave!==true){
			if($retSave==23000)
				return "id_lot_deja_existant";
			else
				return $retSave;
		}

		//on ajoute toutes ses "options"
		//on transforme les stdClass en tableau
		$plusTab=array();
		array_push($plusTab, array("Type(s) de bien"=>$typeDeBien));
		array_push($plusTab, array("Nombre de pièce(s)"=>$nombrePiece));
		foreach ($plus as $value) {
			$tabTemp=array();
			$tabTemp["categorie"]=$value->categorie;
			$tabTemp["valeur"]=$value->valeur;
			array_push($plusTab, $tabTemp);
		}

		$tabIdValeurs=ModelCategories::arrayCategorieAndValeurToId($plusTab);
		if($tabIdValeurs===false){
			return "categorie_valeur_non_reconnue";
		}
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
        if(!file_exists(File::build_path(array("..","image",$id,$i.".jpg")))){
        	return "probleme_creation_fichier";
        }
        if(!exif_imagetype(File::build_path(array("..","image",$id,$i.".jpg")))){
        	return "mauvais_format";
        }
        return "fait";
	}

	public function supprimerImages(){
		if(!$this->auth){
			return "pas connecté";
		}
		$files = glob(File::build_path(array("..","image","*"))); 
		foreach($files as $file){ 
			if(!is_file($file)){
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

	public function supprimerImagesLot($id){
		if(!$this->auth){
			return "pas connecté";
		}
		$files = glob(File::build_path(array("..","image",$id, "*"))); 
		foreach($files as $file){ 
	    	unlink($file);
		}
		rmdir(File::build_path(array("..","image",$id)));
		if(is_dir(File::build_path(array("..","image",$id)))){
			return "probleme_de_droit";
		}
		return "fait";		
	}

	public function getAllCategoriesValeurs(){
		$tabCategories = ModelCategories::getAllValeursCategories();
		foreach ($tabCategories as $categorie) {
			foreach ($categorie as $value) {
				unset($value->id);
			}
		}
		return $tabCategories;
	}

	public function supprimerValeur($categorie,$valeur){
		$id=ModelCategories::CategorieAndValeurToId($categorie,$valeur);
		if($id==false){
			return "categorie_et_valeur_non_connues";
		}
		$sql="delete from sousCategorie where id=$id";
		Serv::$pdo->exec($sql);
		return "fait";
	}

	public function supprimerCategorie($categorie){
		$categorie=ModelCategories::selectCol("categorie",$categorie);
		if($categorie==false){
			return "categorie_inexistante";
		}
		$categorie=$categorie[0];
		ModelCategories::delete($categorie->getId());
		return "fait";
	}

	public function supprimerCategoriesValeurs(){
		ModelCategories::deleteAllCategories();
		return "fait"; 
	}

	public function mettreAJourLot($id,$ville, $surface, $loyer, $typeDeBien, $nombrePiece, $description, $informationsCommercial, $plus){
		if(!$this->auth){
			return "pas connecté";
		}

		$retSup=$this->supprimerUnLot($id);
		if(strcmp($retSup, "lot_n_existe_pas")==0){
			return "lot_n_existe_pas";
		}

		$retCreation=$this->creerLot($id,$ville, $surface, $loyer, $typeDeBien, $nombrePiece, $description, $informationsCommercial, $plus);
		if(strcmp($retCreation, "fait")!==0){
			return "probleme_enregistrement_lot";
		}
		return "fait";
	}

	public function supprimerLots(){
		if(!$this->auth){
			return "pas connecté";
		}
		$sql="delete from lot";
		Serv::$pdo->exec($sql);
		return "fait";
	}

	public function supprimerUnLot($id){
		if(!$this->auth){
			return "pas connecté";
		}
		$sqlNb="select * from lot where id=\"$id\"";
		$result=Serv::$pdo->query($sqlNb);
		if(count($result->fetchAll())==0){
			return "lot_n_existe_pas";
		}

		$sql="delete from lot where id=\"$id\"";
		Serv::$pdo->exec($sql);

		if(strcmp($this->supprimerImagesLot($id), "fait")!==0){
			return "probleme_suppression_image";
		}

		return "fait";
	}

	public function saveCategorieEtValeur($categorie, $valeur){
		if(!$this->auth){
			return "pas connecté";
		}
		$sql="select * from categories where categorie =\"$categorie\"";
		//return $sql;
		$categorieExiste = Serv::$pdo->query($sql);
		if(count($categorieExiste->fetchAll())==0){
			//si la categorie n'est pas enregistrée dans la base on doit l'enregistrer
			$sql="insert into categories(categorie) values(\"$categorie\")";
			Serv::$pdo->exec($sql);
		}
		$categorieId=ModelCategories::categorieNameToId($categorie);
		$sql="insert into sousCategorie(categorieId, valeur) values ($categorieId,\"$valeur\")";
		Serv::$pdo->exec($sql);
		return "fait"; 
	}

	public function getAllAlertesActive(){
		if(!$this->auth){
			return "pas connecté";
		}
		$tabAlerte=ModelAlerte::selectCol("activeMail",true);
		$tabCriteres=array();
		foreach ($tabAlerte as $alerte) {
			$temp=array();
			$alerte->decode();
			$temp["loginUtilisateur"]=$alerte->getLoginUtilisateur();
			$temp["tabSimple"]=$alerte->getTabSimple();
			array_push($tabCriteres, $temp)
		}
		return $tabAlerte;
	}


}

Serv::init();
$test=new Serv();