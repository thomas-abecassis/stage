<?php
//require_once "../lib/File.php";
require_once File::build_path(array("model", "Model.php"));
require_once File::build_path(array("model", "ModelLotApprofondi.php"));

class ModelAlerte extends Model{

  private $loginUtilisateur;
  private $tabSimple;
  private $tabTypesBien;
  private $tabNombrePieces;
  private $tabCheckBox;
  private $nom;
  private $idAlerte;
  private $activeMail;
  protected static $object = "alerte";
  protected static $primary='idAlerte';

      
  public function __construct($idAlerte = NULL,$loginUtilisateur = NULL,$tabSimple = NULL,$tabTypesBien = NULL,$tabNombrePieces = NULL,$tabCheckBox = NULL,$nom = NULL, $activeMail = NULL) {
    if ( !is_null($loginUtilisateur) && !is_null($tabSimple) && !is_null($tabTypesBien) && !is_null($tabNombrePieces) && !is_null($tabCheckBox) && !is_null($nom) && !is_null($activeMail)) {
      $this->loginUtilisateur = $loginUtilisateur;
      $this->tabSimple = $tabSimple;
      $this->tabTypesBien = $tabTypesBien;
      $this->tabNombrePieces =$tabNombrePieces;
      $this->tabCheckBox = $tabCheckBox;
      $this->nom = $nom;
      $this->idAlerte = $idAlerte;
      $this->activeMail = $activeMail;
      }
      $this->checkArray();
  }

  private function checkArray(){
    if(is_null(json_decode($this->tabSimple))){
      $this->tabSimple= "[]";
    }
    if(is_null(json_decode($this->tabTypesBien))){
      $this->tabTypesBien= "[]";
    }
    if(is_null(json_decode($this->tabNombrePieces))){
      $this->tabNombrePieces= "[]";
    }
    if(is_null(json_decode($this->tabCheckBox))){
      $this->tabCheckBox= "[]";
    }
  }

  public function decode(){
  	  $this->tabSimple=json_decode($this->tabSimple, true);
      $this->tabTypesBien=json_decode($this->tabTypesBien, true);
      $this->tabNombrePieces=json_decode($this->tabNombrePieces, true);
      $this->tabCheckBox=json_decode($this->tabCheckBox, true);
  }

  public function getTabSimple(){
  	return $this->tabSimple;
  }

  public function getTabTypesBien(){
  	return $this->tabTypesBien;
  }

  public function getTabNombrePieces(){
  	return $this->tabNombrePieces;
  }

  public function getTabCheckBox(){
  	return $this->tabCheckBox;
  }

  public function getNom(){
  	return $this->nom;
  }

  public function getId(){
  	return $this->idAlerte;
  }

  public function getActiveMail(){
    return $this->activeMail;
  }

  public function setNom($nom){
  	$this->nom=$nom;
  }


  public function getLocalisation(){
  	if($this->tabSimple["localisation"]!==""){
  		return $this->tabSimple["localisation"];
  	}
  	return "Toute la France";
  }

  public function getSurfaceStr(){
  	if($this->tabSimple["minSurface"]!==""){
  		return $this->tabSimple["minSurface"] . "ou plus";	
  	}
  	return "Toute surface";
  }

    public function getBudgetStr(){
  	 if($this->tabSimple["minBudget"]!=="" && $this->tabSimple["maxBudget"]==""){
  		return "plus de ". $this->tabSimple["minBudget"]."€";
  	}
  	if($this->tabSimple["minBudget"]=="" && $this->tabSimple["maxBudget"]!==""){
  		return "moins de " . $this->tabSimple["maxBudget"]."€"; 
  	}
  	if( $this->tabSimple["maxBudget"]!==""){
  		return $this->tabSimple["minBudget"]."€ - ".$this->tabSimple["maxBudget"]."€"; 
  	}
  	return "Tout Budget";
  }

  public function getLoginUtilisateur(){
  	return $this->loginUtilisateur;
  }

  public static function checkAll(){
  	$allAlerte=ModelAlerte::selectAll();
  	foreach ($allAlerte as $alerte) {
  		if($alerte->check()){
  			$alerte->envoiMail();
  		}
  	}
  }

  public static function alerteCorrespondToUser($id,$login){
  	echo $id;
  	$alerte=ModelAlerte::select($id);
  	return $alerte->getLoginUtilisateur()==$login;
  }

  public function check(){
    $this->decode();
    if(!array_filter($this->tabTypesBien) && !array_filter($this->tabNombrePieces) && !array_filter($this->tabCheckBox) && !array_filter($this->tabSimple)){
      $sql="select * from lot where dateEnregistrement >DATE_SUB(NOW(), INTERVAL 60 MINUTE)";
    }
    else{
  	   $sql=ModelLotApprofondi::getSqlForDeepSearch($this->tabTypesBien,$this->tabNombrePieces,$this->tabCheckBox,$this->tabSimple);
  	   $sql=$sql." AND dateEnregistrement >DATE_SUB(NOW(), INTERVAL 60 MINUTE);";
    }
    var_dump($sql);
    $rep=Model::$pdo->query($sql);
    $rep=$rep->fetchAll(PDO::FETCH_CLASS, 'ModelLot');
    return $rep!=false;
  }

  public function envoiMail(){
  	echo $this->loginUtilisateur;
  }

  public function updated(){
  	ModelAlerte::update($this->getTab());
  }

  public function getTab(){
  	return get_object_vars($this);
  }

  public static function unsetSession(){
    $_SESSION["dataFirst"]=array();
    $_SESSION["typesBien"]=array();
    $_SESSION["nombrePieces"]=array();
    $_SESSION["dataCheckBox"]=array();
  }



}

//ModelAlerte::checkAll();

?>

