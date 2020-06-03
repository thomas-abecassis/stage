<?php

require_once File::build_path(array("model", "Model.php"));

class Modellot extends Model{

  private $id;
  private $localisation;
  private $surface;
  private $loyer;
  private $description;
  private $typeDeBien;
  private $nombrePiece;
  private $informationsCommercial;
  protected static $object = "lot";
  protected static $primary='id';


  // un getter
  public function getid() {
       return $this->id;
  }

  // un setter
  public function setid($id2) {
       $this->id = $id2;
  }

  public function getTypeDeBien(){
    return $this->typeDeBien;
  }

  public function getNombrePiece(){
    return $this->nombrePiece;
  }

  public function getnom(){
    return $this->typeDeBien . " " . $this->nombrePiece . " pièces ";
  }

  public function getLoyer(){
    return $this->loyer;
  }

  public function getInformationsCommercial(){
    return $this->informationsCommercial;
  }

  public function setprix($prix){
    if(strlen($prix)==8){
    $this->prix=$prix;
    }
    else{
      echo"oupsi";
    }
  }

  public function getSurface(){
    return $this->surface;
  }

  public function getDescription(){
    return $this->description;
  }

  public function getLocalisation(){
    return $this->localisation;
  }

  public function getTab(){
    return get_object_vars($this);
  }

public function __construct($i = NULL, $loc = NULL, $loy = NULL, $sur = NULL,$d = NULL,$inf = NULL) {
  if (!is_null($i)  && !is_null($loc) && !is_null($loy) && !is_null($sur) && !is_null($d)) {
    $this->id = $i;
    $this->localisation = $loc;
    $this->loyer = $loy;
    $this->surface = $sur;
    $this->d=$d;
    $this->informationsCommercial=$inf;
  }
}


  public static function selectByRecherche($data,$page){
    if(!array_filter($data)){
      $sql="select * from lot";
    }else{
      $sql=ModelLot::getSqlSearch($data);
    }
    $sql=$sql." LIMIT " . (($page-1)*15) . ", 15";
      // Préparation de la requête
      $req_prep = Model::$pdo->prepare($sql);

      $values = ModelLot::getTableauPrep($data);
      // On donne les valeurs et on exécute la requête
      $req_prep->execute($values);

          // On récupère les résultats comme précédemment
    $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelLot');
    $tab_lot = $req_prep->fetchAll();
    // Attention, si il n'y a pas de résultats, on renvoie false
    if (empty($tab_lot))
        return false;
    return $tab_lot;
  }

  public static function getTableauPrep($data){
    $tabPrep=array();
    foreach ($data as $key => $v) {
      if(strlen($v)!=0){
        $tabPrep[$key]=$v;
      }
    }
    return $tabPrep;
  }

  public static function getNbLotRecherche($data){
    if(!array_filter($data)){
      $sql="select count(*) as nbLot from lot";
    }else{
      $sql="select count(*) as nbLot from ( " . ModelLot::getSqlSearch($data) . " ) as recherche";
    }
    $req_prep = Model::$pdo->prepare($sql);
    $values = ModelLot::getTableauPrep($data);

    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    $tab_lot= $req_prep->fetchAll();
    return $tab_lot[0]->nbLot;
  }

  //refactorisation à faire 
  public static function getSqlSearch($data){
      $sql = "SELECT * from lot WHERE";
      $firstCondition=true;

      if(strlen($data["localisation"])!=0){
        $firstCondition=false;
        $sql=$sql." localisation = :localisation";
      }
      if(strlen($data["minSurface"])!=0){
        if(!$firstCondition){
          $sql=$sql." AND";
        }
        $sql=$sql." surface >= :minSurface";
        $firstCondition=false;
      }
      if(strlen($data["maxSurface"])!=0){
        if(!$firstCondition){
          $sql=$sql." AND";
        }
        $sql=$sql." surface <= :maxSurface";
        $firstCondition=false;
      }
      if(strlen($data["minBudget"])!=0){
        if(!$firstCondition){
          $sql=$sql." AND";
        }
        $sql=$sql." loyer >= :minBudget";
        $firstCondition=false;
      }
      if(strlen($data["maxBudget"])!=0){
        if(!$firstCondition){
          $sql=$sql." AND";
        }
        $sql=$sql." loyer <= :maxBudget" ;
        $firstCondition=false;
      }
      return $sql;
  }

}
?>