<?php

require_once File::build_path(array("model", "Model.php"));
require_once File::build_path(array("model", "ModelLot.php"));
require_once File::build_path(array("model", "ModelCategorie.php"));

class ModelLotApprofondi {
   
  private $modelLot;
  private $plus;
      
  public function __construct($modelLot = NULL) {
    if (!is_null($modelLot) ) {
      $this->modelLot = $modelLot;
      $this->plus=ModelCategorie::getValeursCategoriesLot($this);
      }
  }

  public function getnom(){
    $getTypeDeBien=$this->getTypeDeBien();
    $nombreDePiece=$this->getNombreDePiece();

    $nom=$this->getTypeDeBien();
    if($nombreDePiece!==false){
      $nom=$nom . " " . $nombreDePiece . " pièces ";
    }
    if(empty($nom)){
      return " de bien";
    }
    return $nom;
  }

  public function getTypeDeBien(){
    if(array_key_exists("Type(s) de bien",$this->plus)){
      return $this->plus["Type(s) de bien"][0];
    }
      return "";
  }

  public function getNombreDePiece(){
    if(array_key_exists("Nombre de pièces",$this->plus)){
      return $this->plus["Nombre de pièces"][0];
    }
      return false;
  }

  public function getPlus(){
    return $this->plus;
  }

  public function getLot(){
    return $this->modelLot;
  }


  public static function searchDeep($dataCheckBox,$dataPost,$page){
   if( !array_filter($dataCheckBox) && !array_filter($dataPost)){
      $sql="select * from lot";
    }else{
      $sql=ModelLotApprofondi::getSqlForDeepSearch($dataCheckBox,$dataPost);
    }
    $sql=$sql." group by id LIMIT " . (($page-1)*15) . ", 15";
    $req_prep = Model::$pdo->prepare($sql);

    $values = ModelLot::getTableauPrep($dataPost);

    $req_prep->execute($values);
    if($req_prep==false){
      return array();
    }
    $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelLot');
    //return $req_prep->fetchAll();
    $test=$req_prep->fetchAll();
    return ModelLotApprofondi::lotsToLotsApprofondi($test);

  }

  private static function lotToLotApprofondi($lot,$tabValeursCategories){
    $id=$lot->getId();
    $sql="select idValeurCategorie FROM `lotCategorie` where idLot=:id";

    $values=array("id" => $id );

    $req_prep = Model::$pdo->prepare($sql);
    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    $rep = $req_prep->fetchAll();

    $tabValeurs= array();
    foreach ($rep as $valeur){
      array_push($tabValeurs, ModelCategorie::searchId($tabValeursCategories, $valeur->idValeurCategorie));
    }
    return new ModelLotApprofondi($lot, $tabValeurs);
  }

  private static function lotsToLotsApprofondi($tabLots){
    $valeurs=ModelCategorie::getAllValeursCategories();
    $tabLotsApprofondis = array();
    foreach ($tabLots as $lot) {
      array_push($tabLotsApprofondis, ModelLotApprofondi::lotToLotApprofondi($lot,$valeurs));
    }
    return $tabLotsApprofondis;
  }

  public static function getSqlForDeepSearch($dataCheckBox,$dataPost){
    $sql=ModelLot::getSqlSearch($dataPost);
    if(!count($dataCheckBox)){
      return $sql;
    }
    $sql="select * from ($sql) as lot join lotCategorie on lotCategorie.idLot=lot.id";
    $isFirst=true;
    foreach ($dataCheckBox as  $value ) {
      if($isFirst){
        $sql=$sql . " where idValeurCategorie=" . $value;
        $isFirst=false;
      }
      else{
        $sql=$sql . " or idValeurCategorie=" . $value;
      }
    }
    return $sql;
  }

  public static function getNbLotRecherche($dataCheckBox,$dataPost){
    if( !array_filter($dataCheckBox) && !array_filter($dataPost)){
      $sql="select count(*) as nbLot from lot";
    }else{
      $sql="select count(*) as nbLot from ( " . ModelLotApprofondi::getSqlForDeepSearch($dataCheckBox,$dataPost) . " ) as recherche ";
    }
    $req_prep = Model::$pdo->prepare($sql);
    $values = ModelLot::getTableauPrep($dataPost);

    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    $tab_lot= $req_prep->fetchAll();
    return $tab_lot[0]->nbLot;
  }

  public static function unsetSession(){
    $_SESSION['dataCheckBox']=array();
    $_SESSION['dataPost']=array();
  }

  public static function setSession($dataCheckBox){
    $_SESSION['dataCheckBox']=$dataCheckBox;
  }

}
?>