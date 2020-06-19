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
  private $location;
  private $mail;
  private $telephone;
  protected static $object = "lot";
  protected static $primary='id';

public function __construct($i = NULL, $loc = NULL, $loy = NULL, $sur = NULL,$d = NULL,$inf = NULL, $t = NULL, $nb = NULL,$location = NULL, $mail = NULL, $telephone = NULL) {
  if (!is_null($i)  && !is_null($loc) && !is_null($loy) && !is_null($sur) && !is_null($d) && !is_null($t) && !is_null($nb) && !is_null($location)) {
    $this->id = $i;
    $this->localisation = $loc;
    $this->loyer = $loy;
    $this->surface = $sur;
    $this->description=$d;
    $this->informationsCommercial=$inf;
    $this->typeDeBien=$t;
    $this->nombreDePieces = $nb;
    $this->location = $location;
    $this->mail = $mail;
    $this->telephone = $telephone;
  }
}
  // un getter
  public function getid() {
       return $this->id;
  }

  public function getnom(){
    if($this->location)
      $typeDeVente="location ";
    else
      $typeDeVente="vente ";
    if($this->nombreDePieces==1)
      $pieces = " pièce";
    else
      $pieces = " pièces";
    return $typeDeVente . $this->typeDeBien . " " . $this->nombreDePieces . $pieces;
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

  public function getMail(){
    return $this->mail;
  }

  public function getTelephone(){
    return $this->telephone;
  }


  public function setLocalisation($localisation){
    $this->localisation=$localisation;
  }

  public function setMail($mail){
    $this->mail=$mail;
  }

  public function setTelephone($telephone){
    $this->telephone=$telephone;
  }



  public function getLocalisationId(){
    $resultat=Model::requete("select id from villesFrance where UPPER(nom) = UPPER(:localisation)",array("localisation"=>$this->localisation));
    return $resultat[0]->id;
  }

  public function getTab(){
    return get_object_vars($this);
  }

  public static function selectById($id){
    $sql="select lot.id,nom as localisation,surface, loyer, description, informationsCommercial, typeDeBien, nombreDePieces, location, mailLot.mail, telephoneLot.telephone from lot JOIN villesFrance on villesFrance.id=lot.localisation left join mailLot on mailLot.id=lot.mail left join telephoneLot on telephoneLot.id=lot.telephone where lot.id=:id";

    $req_prep = Model::$pdo->prepare($sql);

    $values = array("id"=>$id);
    $req_prep->execute($values);

    $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelLot');
    $lot = $req_prep->fetchAll();
    if(count($lot)==0) return false;
    return $lot[0]; 
  }

  public static function selectByRecherche($data,$page){
    if(!array_filter($data)){
    $sql="select lot.id,nom as localisation,surface, loyer, description, informationsCommercial, typeDeBien, nombreDePieces, location, mailLot.mail, telephoneLot.telephone from lot JOIN villesFrance on villesFrance.id=lot.localisation left join mailLot on mailLot.id=lot.mail left join telephoneLot on telephoneLot.id=lot.telephone";
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
    $sql="select lot.id,nom as localisation,surface, loyer, description, informationsCommercial, typeDeBien, nombreDePieces, location, mailLot.mail, telephoneLot.telephone from lot JOIN villesFrance on villesFrance.id=lot.localisation left join mailLot on mailLot.id=lot.mail left join telephoneLot on telephoneLot.id=lot.telephone where";
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
      return "select lot.id,nom as localisation,surface, loyer, description, informationsCommercial, typeDeBien, nombreDePieces, location, mailLot.mail, telephoneLot.telephone from lot JOIN villesFrance on villesFrance.id=lot.localisation left join mailLot on mailLot.id=lot.mail left join telephoneLot on telephoneLot.id=lot.telephone";
  }

}
