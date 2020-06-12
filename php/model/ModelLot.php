<?php

require_once File::build_path(array("model", "Model.php"));

class Modellot extends Model{

  private $id;
  private $localisation;
  private $surface;
  private $loyer;
  private $description;
  private $informationsCommercial;
  private $typeDeBien;
  private $nombreDePieces;
  protected static $object = "lot";
  protected static $primary='id';


  // un getter
  public function getid() {
       return $this->id;
  }

  public function getnom(){
    $TypeDeBien=$this->typeDeBien;
    $nombreDePiece=$this->nombreDePieces;

    $nom=$TypeDeBien;
    if($nombreDePiece!==false){
      $nom=$nom . " " . $nombreDePiece . " pièces ";
    }
    if(empty($nom)){
      return " de bien";
    }
    return $nom;
  }

  public function getTypeDeBien(){
    return $this->typeDeBien;
  }

  public function getNombreDePieces(){
    return $this->nombreDePieces;
    }

  // un setter
  public function setid($id2) {
       $this->id = $id2;
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

public function __construct($i = NULL, $loc = NULL, $loy = NULL, $sur = NULL,$d = NULL,$inf = NULL, $t = NULL, $nb = NULL) {
  if (!is_null($i)  && !is_null($loc) && !is_null($loy) && !is_null($sur) && !is_null($d) && !is_null($t) && !is_null($nb)) {
    $this->id = $i;
    $this->localisation = $loc;
    $this->loyer = $loy;
    $this->surface = $sur;
    $this->description=$d;
    $this->informationsCommercial=$inf;
    $this->typeDeBien=$t;
    $this->nombreDePieces = $nb;
  }
}


  public static function selectByRecherche($data,$page){
    if(!array_filter($data)){
      $sql="select lot.id,nom as localisation,surface, loyer, description, informationsCommercial, typeDeBien, nombreDePieces from lot JOIN villesFrance on villesFrance.id=lot.localisation ";
    }else{
      $sql=ModelLot::getSqlSearch($data);
    }
    $sql=$sql." LIMIT " . (($page-1)*15) . ", 15 ";
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

  public static function getSqlSearch($data){
      $sql = "select lot.id,nom as localisation,surface, loyer, description, informationsCommercial, typeDeBien, nombreDePieces from lot JOIN villesFrance on villesFrance.id=lot.localisation  WHERE";
      $firstCondition=true;

      $arr=array(
        "localisation" => "villesFrance.nom =",
        "minSurface" => " surface >=",
        "maxSurface" => "surface <=",
        "minBudget" => "loyer >=",
        "maxBudget" => "loyer <="
      );

      foreach($arr as $key => $value){
        if(strlen($data[$key])!=0){
          if(!$firstCondition){
            $sql=$sql." AND";
          }
          $sql=$sql. " " . $value ." :". $key;
          $firstCondition=false;
        }
      }
      if(!$firstCondition){
        return $sql;
      }
      return "select lot.id,nom as localisation,surface, loyer, description, informationsCommercial, typeDeBien, nombreDePieces from lot JOIN villesFrance on villesFrance.id=lot.localisation";
  }

}
?>