<?php

require_once File::build_path(array("model", "Model.php"));

class Modellot extends Model{

  private $id;
  private $nom;
  private $localisation;
  private $surface;
  private $loyer;
  private $description;
  private $typeDeBien;
  private $nombrePiece;
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
    return $this->nom;
  }

  public function setnom($nom){
    $this->nom=$nom;
  }

  public function getLoyer(){
    return $this->loyer;
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

public function __construct($i = NULL, $n = NULL, $loc = NULL, $loy = NULL, $sur = NULL,$d = NULL) {
  if (!is_null($i) && !is_null($n) && !is_null($loc) && !is_null($loy) && !is_null($sur) && !is_null($d)) {
    // Si aucun de $m, $c et $i sont nuls,
    // c'est forcement qu'on les a fournis
    // donc on retombe sur le constructeur à 3 arguments
    $this->id = $i;
    $this->nom = $n;
    $this->localisation = $loc;
    $this->loyer = $loy;
    $this->surface = $sur;
    $this->d=$d;
  }
}

public static function getAlllots(){
  $rep=Model::$pdo->query('select * from lot');
  return $rep->fetchAll(PDO::FETCH_CLASS, 'ModelLot');
}



  /* une methode d'affichage.
  public function afficher() {
    echo "lot $this->prix de id $this->id (nom $this->nom)";
  }*/


  public static function getlotByImmat($immat) {
    $sql = "SELECT * from lot WHERE prix=:nom_tag";
    // Préparation de la requête
    $req_prep = Model::$pdo->prepare($sql);

    $values = array(
        "nom_tag" => $immat,
        //nomdutag => valeur, ...
    );
    // On donne les valeurs et on exécute la requête
    $req_prep->execute($values);

    // On récupère les résultats comme précédemment
    $req_prep->setFetchMode(PDO::FETCH_CLASS, 'lot');
    $tab_voit = $req_prep->fetchAll();
    // Attention, si il n'y a pas de résultats, on renvoie false
    if (empty($tab_voit))
        return false;
    return $tab_voit[0];
  }

  public static function deletelotByImmat($immat) {
    $sql = "DELETE from lot WHERE prix=:nom_tag";
    // Préparation de la requête
    $req_prep = Model::$pdo->prepare($sql);

    $values = array(
        "nom_tag" => $immat,
        //nomdutag => valeur, ...
    );
    // On donne les valeurs et on exécute la requête
    $req_prep->execute($values);

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
    $tab_voit = $req_prep->fetchAll();
    // Attention, si il n'y a pas de résultats, on renvoie false
    if (empty($tab_voit))
        return false;
    return $tab_voit;
  }

  public static function getTableauPrep($data){
    $ar=array();
    foreach ($data as $key => $v) {
      if(strlen($v)!=0){
        $ar[$key]=$v;
      }
    }
    return $ar;
  }

  public static function getNbLotRecherche($data){
    if(!array_filter($data)){
      $sql="select * from lot";
    }else{
      $sql=ModelLot::getSqlSearch($data);
    }
    $req_prep = Model::$pdo->prepare($sql);
    $values = ModelLot::getTableauPrep($data);

    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelLot');
    $tab_lot= $req_prep->fetchAll();
    return count($tab_lot);
  }

  public static function getSqlSearch($data){
      $_SESSION['dataFirst']=$data;
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
        $sql=$sql." surface > :minSurface";
        $firstCondition=false;
      }
      if(strlen($data["minBudget"])!=0){
        if(!$firstCondition){
          $sql=$sql." AND";
        }
        $sql=$sql." loyer > :minBudget";
        $firstCondition=false;
      }
      if(strlen($data["maxBudget"])!=0){
        if(!$firstCondition){
          $sql=$sql." AND";
        }
        $sql=$sql." loyer < :maxBudget" ;
        $firstCondition=false;
      }
      return $sql;
  }

  public static function unsetSession(){
    $_SESSION['typesBien']=array();
    $_SESSION['nombrePieces']=array();
    $_SESSION['dataCheckBox']=array();
  }
}
?>