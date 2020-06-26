<?php

require_once "File.php";
require_once File::build_path(array("config","Conf.php"));
require_once File::build_path(array("model","ModelLot.php"));
require_once File::build_path(array("model","ModelCategories.php"));
require_once File::build_path(array("model","ModelAlerte.php"));
require_once File::build_path(array("model","ModelUtilisateur.php"));
require_once File::build_path(array("model","ModelMail.php"));
require_once File::build_path(array("model","ModelTelephone.php"));


class Serv{

	private static $pdo;

    private $auth = false;


	public static function Init(){
		$hostname = Conf::getHostName();
		$database_name = Conf::getDatabase();
		$login = Conf::getLogin();
		$password = Conf::getPassword();
		try {
			self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password,
                     array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));		}
        catch (PDOException $e) {
			echo $e->getMessage(); // affiche un message d'erreur
			die();
		}
		self::$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
	}


	public function authentification($obj){
		$login="test";
		$password="toast";
		if($obj->login === $login && $obj->password === $password){
			$this->auth = true;
		}
		else{
			return "mauvais login et mdp ";
		}
	}

	public function creerLot($id,$ville, $surface, $loyer, $typeDeBien, $nombrePiece, $description, $informationsCommercial, $mail, $telephone, $plus){
		if(!$this->auth){
			return "pas connecté";
		}
		$mail=getId("mail", $mail);
		$telephone=getId("telephone", $telephone);

		$lot=new ModelLot($id,$ville, $loyer, $surface, $description, $informationsCommercial, $typeDeBien, $nombrePiece,1, $mail, $telephone);

		$villeId=$lot->getLocalisationId();
    	if(is_null($villeId))
      		return "nom_de_ville_inconnu";

    	$lot->setLocalisation($villeId); //On stoque l'ID de la ville dans la table lot 

		//met en forme les plus pour créer un lotApprofondi
		$tab=metEnFormeTableau($typeDeBien, $nombrePiece, $plus);

		$lotApprofondi=new ModelLotApprofondi($lot, $tab);
		return $lotApprofondi->saveLotApprofondi();
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
		if(!$this->auth){
			return "pas connecté";
		}
		$tabCategories = ModelCategories::getAllValeursCategories();
		foreach ($tabCategories as $categorie) {
			foreach ($categorie as $value) {
				unset($value->id);
			}
		}
		return $tabCategories;
	}

	public function supprimerValeur($categorie,$valeur){
		if(!$this->auth){
			return "pas connecté";
		}
		$id=ModelCategories::CategorieAndValeurToId($categorie,$valeur);
		if($id==false){
			return "categorie_et_valeur_non_connues";
		}
		$sql="delete from sousCategorie where id=$id";
		Serv::$pdo->exec($sql);
		return "fait";
	}

	public function supprimerCategorie($categorie){
		if(!$this->auth){
			return "pas connecté";
		}
		$categorie=ModelCategories::selectCol("categorie",$categorie);
		if($categorie==false){
			return "categorie_inexistante";
		}
		$categorie=$categorie[0];
		ModelCategories::delete($categorie->getId());
		return "fait";
	}

	public function supprimerCategoriesValeurs(){
		if(!$this->auth){
			return "pas connecté";
		}
		ModelCategories::deleteAll();
		return "fait"; 
	}

	public function mettreAJourLot($id,$ville, $surface, $loyer, $typeDeBien, $nombrePiece, $description, $informationsCommercial, $mail, $telephone, $plus){
		if(!$this->auth){
			return "pas connecté";
		}

		$ancienLotApprofondi=ModelLotApprofondi::selectById($id);

		if($ancienLotApprofondi==false)
			return "lot_n_existe_pas";
		
		$this->supprimerUnLot($id);

		$mail=getId("mail", $mail);
		$telephone=getId("telephone", $telephone);

		$lot=new ModelLot($id,$ville, $loyer, $surface, $description, $informationsCommercial, $typeDeBien, $nombrePiece,1, $mail, $telephone);

		$villeId=$lot->getLocalisationId();
    	if(is_null($villeId))
      		return "nom_de_ville_inconnu";

    	$lot->setLocalisation($villeId); //On stoque l'ID de la ville dans la table lot 

		$tab=metEnFormeTableau($typeDeBien, $nombrePiece, $plus);
		$nouveauLotApprofondi=new ModelLotApprofondi($lot, $tab);

		$retCreation=$nouveauLotApprofondi->saveLotApprofondi(); 
		if($retCreation !== "fait"){

			//dans le cas de problème de mise à jour on resupprime le lot et on le re-enregistre dans son etat initial
			$this->supprimerUnLot($id);
			$villeId=$ancienLotApprofondi->getLot()->getLocalisationId();
			$ancienLotApprofondi->getLot()->setLocalisation($villeId);
			$mail=getId("mail", $ancienLotApprofondi->getLot()->getMail());
			$telephone=getId("telephone", $ancienLotApprofondi->getLot()->getTelephone());
			$ancienLotApprofondi->getLot()->setMail($mail);
			$ancienLotApprofondi->getLot()->setTelephone($telephone);
			$ancienLotApprofondi->saveLotApprofondi();
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

		if($this->supprimerImagesLot($id) !== "fait"){
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
		$categorieId=ModelCategories::selectCol("categorie", $categorie)[0]->getId();
		$sql="insert into sousCategorie(categorieId, valeur) values ($categorieId,\"$valeur\")";
		Serv::$pdo->exec($sql);
		return "fait"; 
	}

	public function getAllAlertesActive(){
		if(!$this->auth){
			return "pas connecté";
		}

		$tabAlerte=ModelAlerte::selectCol("activeMail",true);
		$tabSoapVar=array();
		foreach ($tabAlerte as $alerte) {
			$temp=array();
			$alerte->decode();
			$temp["loginUtilisateur"]=$alerte->getLoginUtilisateur();
			$temp["tabSimple"]=$alerte->getTabSimple();
			array_push($tabSoapVar, new SoapVar($alerte, SOAP_ENC_OBJECT, null, null, 'alerte' ));
		}
		return new SoapVar($tabSoapVar, SOAP_ENC_OBJECT, null, null, 'tabAlerte');
	}

	public function getUtilisateursInactifs($nombreDeSemaines){
		if(!$this->auth){
			return "pas connecté";
		}
		$tabUtilisateurs=ModelUtilisateur::selectBySemainesSansConnexion($nombreDeSemaines);
		$tabSoapVar=array();
		foreach ($tabUtilisateurs as $utilisateur) {
			array_push($tabSoapVar, new SoapVar($utilisateur, SOAP_ENC_OBJECT, null, null, 'utilisateur' ));
		}
		return new SoapVar($tabSoapVar, SOAP_ENC_OBJECT, null, null, 'tabUtilisateurs');
	}

	public function supprimerUtilisateur($loginUtilisateur){
		//supprime l'utilisateur dont le login correspond à celui passé en paramètre
		ModelUtilisateur::delete($loginUtilisateur);
		return "fait";
	}

	public function supprimerAlertesUtilisateur($loginUtilisateur){
		if(ModelUtilisateur::select($loginUtilisateur)===false){
			return "login_inconnu";
		}
		ModelAlerte::deleteFromUsers($loginUtilisateur);
		return "fait";
	}
}

function metEnFormeTableau($typeDeBien,$nombrePiece,$plus){
	//cette fonction sert à transformer les tableaux donnés en entrée en un seul tableau mis en forme pour un LotApprofondi
		if(intval($nombrePiece)>=6){
			$nombrePiece="6 et plus";
		}
        $tab=array("Type(s) de bien"=> array($typeDeBien), "Nombre de pièce(s)"=> array($nombrePiece));
        foreach ($plus as $tabValeurCategorie) {
            $nomCategorie=$tabValeurCategorie->categorie;
            if(array_key_exists($nomCategorie, $tab)){
                array_push($tab[$nomCategorie], $tabValeurCategorie->valeur);
            }else{
                $tab[$nomCategorie]=array($tabValeurCategorie->valeur);
            }
        }
    return $tab;
}

function getId($nomAttribut, $valeur){
	if($valeur==="")
		return NULL;

	$model="model".ucfirst($nomAttribut);

	if(!is_null($valeur)){
		$obj=$model::selectCol($nomAttribut,$valeur);
		if($obj===false){
			$obj=new $model(NULL, $valeur);
			$obj->save();
			$obj=$model::selectCol($nomAttribut,$valeur);
		}
		return $obj[0][0];
	}
}

Serv::init();
$test=new Serv();