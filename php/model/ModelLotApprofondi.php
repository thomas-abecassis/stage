<?php

require_once File::build_path(array("model", "Model.php"));
require_once File::build_path(array("model", "ModelLot.php"));

class ModelLotApprofondi {
   
  private $modelLot;
  private $plus;
      
  public function __construct($modelLot = NULL) {
    if (!is_null($modelLot) ) {
      $this->modelLot = $modelLot;
      $this->plus=$this->getValeursCategories();
      }
  }

  public function getPlus(){
    return $this->plus;
  }

  public static function searchDeep($dataCheckBox,$dataPost,$page){
   if( !array_filter($dataCheckBox) && !array_filter($dataPost)){
      $sql="select * from lot";
    }else{
      $sql=ModelLotApprofondi::getSqlForDeepSearch($dataCheckBox,$dataPost);
    }
    $sql=$sql." group by id order by dateEnregistrement LIMIT " . (($page-1)*15) . ", 15";
    $req_prep = Model::$pdo->prepare($sql);

    $values = ModelLot::getTableauPrep($dataPost);

    $req_prep->execute($values);
    if($req_prep==false){
      return array();
    }
    $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelLot');
    return $req_prep->fetchAll();
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

  public function getValeursCategories(){
    $sqlCategories = "select distinct categorie,categories.id from lotCategorie join sousCategorie on lotCategorie.idValeurCategorie=sousCategorie.id join categories on categories.id=sousCategorie.categorieId where idLot=\"".$this->modelLot->getId()."\""; 
    $rep=Model::$pdo->query($sqlCategories);
    $rep=$rep->fetchAll(PDO::FETCH_OBJ);
    $valeurs=array();
    foreach ($rep as $categorie) {
      $ar=array();
      $sql="select * from lotCategorie join sousCategorie on lotCategorie.idValeurCategorie=sousCategorie.id join categories on categories.id=sousCategorie.categorieId where categorieId=".$categorie->id. "  and idLot=\"" . $this->modelLot->getId() . "\"";
      $repVal=Model::$pdo->query($sql);
      $repVal=$repVal->fetchAll(PDO::FETCH_OBJ);
      foreach ($repVal as $valeurCategorie) {
        array_push($ar, $valeurCategorie->valeur);
      }
      $valeurs[$categorie->categorie]=$ar;
    }
    return $valeurs;
  }

  public static function getAllCategories(){
    $sql="SELECT * FROM categories";
    $rep=Model::$pdo->query($sql);
    return $rep->fetchAll(PDO::FETCH_OBJ);
  }

  public static function getAllValeursCategories(){
    $categories=ModelLotApprofondi::getAllCategories();
    $valeurs=array();
    foreach ($categories as $categorie) {
      $ar=array();
      $sql="select valeur,id from sousCategorie where categorieId=".$categorie->id;
      $rep=Model::$pdo->query($sql);
      $rep=$rep->fetchAll(PDO::FETCH_OBJ);
      foreach ($rep as $valeurCategorie) {
        array_push($ar, $valeurCategorie);
      }
      $valeurs[$categorie->categorie]=$ar;
    }
    return $valeurs;
  }

  public static function unsetSession(){
    $_SESSION['typesBien']=array();
    $_SESSION['nombrePieces']=array();
    $_SESSION['dataCheckBox']=array();
    $_SESSION['dataPost']=array();
  }

  public static function setSession($typesBien,$nombrePieces,$dataCheckBox){
    $_SESSION['typesBien']=$typesBien;
    $_SESSION['nombrePieces']=$nombrePieces;
    $_SESSION['dataCheckBox']=$dataCheckBox;
  }

}
?>