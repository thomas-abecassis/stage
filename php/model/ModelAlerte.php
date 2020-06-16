<?php
//require_once "../lib/File.php";
require_once File::build_path(array("model", "Model.php"));
require_once File::build_path(array("model", "ModelLotApprofondi.php"));

class ModelAlerte extends Model{

  private $loginUtilisateur;
  private $tabSimple;
  private $tabCheckBox;
  private $nom;
  private $idAlerte;
  private $activeMail;
  protected static $object = "alerte";
  protected static $primary='idAlerte';

      
  public function __construct($idAlerte = NULL,$loginUtilisateur = NULL,$tabSimple = NULL,$tabCheckBox = NULL,$nom = NULL, $activeMail = NULL) {
    if ( !is_null($loginUtilisateur) && !is_null($tabSimple) && !is_null($tabCheckBox) && !is_null($nom) && !is_null($activeMail)) {
        $this->loginUtilisateur = $loginUtilisateur;
        $this->tabSimple = $tabSimple;
        $this->tabCheckBox = $tabCheckBox;
        $this->nom = $nom;
        $this->idAlerte = $idAlerte;
        $this->activeMail = $activeMail;
      }
  }

  public function decode(){
  	  $this->tabSimple=json_decode($this->tabSimple, true);
      $this->tabCheckBox=json_decode($this->tabCheckBox, true);
  }

  public function encode(){
      $this->tabSimple=json_encode($this->tabSimple, true);
      $this->tabCheckBox=json_encode($this->tabCheckBox, true);
  }

  public function getTabSimple(){
  	return $this->tabSimple;
  }

  public function getTabCheckBox(){
  	return $this->tabCheckBox;
  }

  public function getTabTypeDeBien(){
    $temp=array();
    foreach ($this->tabCheckBox as $key => $value) {
      if(strcmp($key, "Type(s) de bien")==0)
        array_push($temp, $value);
    }
    return $temp;
  }

  public function getTabNombreDePieces(){
    $temp=array();
    foreach ($this->tabCheckBox as $key => $value) {
      if(strcmp($key, "Nombre de pièce(s)")==0)
        array_push($temp, $value);
    }
    var_dump($temp);
    return $temp;
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

  public function setActiveMail($bool){
    $this->activeMail=$bool;
  }

  public function setNom($nom){
  	$this->nom=$nom;
  }

  public function getLoginUtilisateur(){
    return $this->loginUtilisateur;
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

  public static function checkAll(){
  	$allAlerte=ModelAlerte::selectCol("activeMail",true);
  	foreach ($allAlerte as $alerte) {
  		if($alerte->check()){
  			$alerte->envoiMail();
  		}
  	}
  }

  public static function alerteCorrespondToUser($id,$login){
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