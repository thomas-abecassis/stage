<?php
require_once File::build_path(array("config", "Conf.php"));
class Model{
	
	public static $pdo;

	public static function Init(){
		$hostname=Conf::getHostName();
		$database_name=Conf::getDatabase();
		$login=Conf::getLogin();
		$password=Conf::getPassword();
		try {
			self::$pdo = new PDO("mysql:host=$hostname;dbname=$database_name", $login, $password,
                     array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));	
			self::$pdo->exec('SET CHARACTER SET UTF-8');
		}
        catch (PDOException $e) {
			if (Conf::getDebug()) {
			  echo $e->getMessage(); // affiche un message d'erreur
			} else {
			  echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
			}
			die();
		}
	}

	public static function selectAll(){
		$table_name=static::$object;
		$class_name="Model".ucfirst($table_name);
		$rep=Model::$pdo->query("select * from ".$table_name);
  		return $rep->fetchAll(PDO::FETCH_CLASS, $class_name); 
	}

	public static function selectCol($columnName,$value){
		$table_name=static::$object;
		$class_name="Model".ucfirst($table_name);

	    $sql = "SELECT * from ".$table_name." WHERE ".$columnName." =:tag";
	    // Préparation de la requête
	    $req_prep = Model::$pdo->prepare($sql);

	    $values = array(
	        "tag" => $value,
	        //nomdutag => valeur, ...
	    );
	    // On donne les valeurs et on exécute la requête	 
	    $req_prep->execute($values);

	    // On récupère les résultats comme précédemment
	    $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
	    $tab_voit = $req_prep->fetchAll();
	    // Attention, si il n'y a pas de résultats, on renvoie false
	    if (empty($tab_voit)){
	        return false;
	    }
	    return $tab_voit;	
	}

	public static function select($primary_value){
		$primary_key=static::$primary;
		$resultat=static::selectCol($primary_key,$primary_value);
		if (!empty($resultat)){
			return $resultat[0];
		}
		return false;
	}

	public static function delete($primary_value){
		$table_name=static::$object;
		$class_name="Model".ucfirst($table_name);
		$primary_key=static::$primary;

	    $sql = "DELETE from ". static::$object ." WHERE " .static::$primary. "=:nom_tag";
	    // Préparation de la requête
	    $req_prep = Model::$pdo->prepare($sql);

	    $values = array(
	        "nom_tag" => $primary_value,
	        //nomdutag => valeur, ...
	    );
	    // On donne les valeurs et on exécute la requête	 
	    $req_prep->execute($values);
	}

	public static function deleteAll(){
		$sql="delete from " . static::$object;
		Model::$pdo->exec($sql);
	}

 public function save(){
 	    Model::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	Model::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$data=$this->getTab();
	  	$sql = "INSERT INTO " . static::$object . " VALUES ( ";
	  	foreach($data as $cle => $valeur){
	  		$sql=$sql.":".$cle." , ";
	  	};
	  	$sql=rtrim($sql,', ');
	  	$sql=$sql.')';

	    // Préparation de la requête
	    $req_prep = Model::$pdo->prepare($sql);
	    try{
	    	$req_prep->execute($data);
	    }
	    catch(PDOException $e){
	    	return  $e->getCode();
	    }
	    return true;	    
  }

  //avec cette fonction on ne peut pas mettre à jour la clé primaire
  public static function update($data){
  	$sql = "UPDATE " . static::$object . " SET ";
  	foreach($data as $cle => $valeur){
  		$sql=$sql.$cle." =:".$cle.", ";
  	};
  	$sql=rtrim($sql,', ');
  	$sql=$sql." WHERE ".static::$primary.'=:'.static::$primary;

    // Préparation de la requête
    $req_prep = Model::$pdo->prepare($sql);

    $req_prep->execute($data);
  }

  //Cette fonction sert à mettre à jour seulement la clé primaire
  public static function updatePrimaryKey($oldPrimaryKey, $newPrimaryKey){
  	$sql="UPDATE " . static::$object . " SET " . static::$primary . '=:newPrimaryKey' . " WHERE ".static::$primary.'=:oldPrimaryKey';

  	$req_prep = Model::$pdo->prepare($sql);

  	$data=array("newPrimaryKey" => $newPrimaryKey,
  				"oldPrimaryKey" => $oldPrimaryKey);

    $req_prep->execute($data);
  }

  //pour executer une requete préparer 
  public static function requete($sql, $tabPrep){

    $req_prep = Model::$pdo->prepare($sql);

    $req_prep->execute($tabPrep);

    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    return $req_prep->fetchAll();
  }
}
Model::Init();