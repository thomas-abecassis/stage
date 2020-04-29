<?php
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
  protected static $object = "alerte";
  protected static $primary='idAlerte';

      
  public function __construct($idAlerte = NULL,$loginUtilisateur = NULL,$tabSimple = NULL,$tabTypesBien = NULL,$tabNombrePieces = NULL,$tabCheckBox = NULL,$nom = NULL) {
    if ( !is_null($loginUtilisateur) && !is_null($tabSimple) && !is_null($tabTypesBien) && !is_null($tabNombrePieces) && !is_null($tabCheckBox) && !is_null($nom)) {
      // Si aucun de $m, $c et $i sont nuls,
      // c'est forcement qu'on les a fournis
      // donc on retombe sur le constructeur à 3 arguments
      $this->loginUtilisateur = $loginUtilisateur;
      $this->tabSimple = $tabSimple;
      $this->tabTypesBien = $tabTypesBien;
      $this->tabNombrePieces =$tabNombrePieces;
      $this->tabCheckBox = $tabCheckBox;
      $this->nom = $nom;
      $this->idAlerte = $idAlerte;
      }
  }

  public function getNom(){
  	return $this->nom;
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

  public function check(){
  	$sql=ModelLotApprofondi::getSqlForDeepSearch(json_decode($this->tabTypesBien, true),json_decode($this->tabNombrePieces, true),json_decode($this->tabCheckBox, true),json_decode($this->tabSimple, true));
  	$sql=$sql." AND dateEnregistrement >DATE_SUB(NOW(), INTERVAL 60 MINUTE);";
    $rep=Model::$pdo->query($sql);
    $rep=$rep->fetchAll(PDO::FETCH_CLASS, 'ModelLot');
    return $rep!=false;
  }

  public function envoiMail(){
  	echo $this->loginUtilisateur;
  }

  public function getTab(){
  	var_dump(get_object_vars($this));
  	return get_object_vars($this);
  }

}

ModelAlerte::checkAll();
?>

