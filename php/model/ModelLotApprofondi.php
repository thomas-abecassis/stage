<?php

require_once File::build_path(array("model", "Model.php"));
require_once File::build_path(array("model", "ModelLot.php"));

class ModelLotApprofondi {
   
  private $modelLot;
  private $typesDePieces;
  private $commodites;
  private $rangements;
  private $orientations;
  private $options;
      
  public function __construct($modelLot = NULL) {
    if (!is_null($modelLot) ) {
      $this->modelLot = $modelLot;
      $this->typesDePieces = $this->getInfosFor("typeDePiecesLot");
      $this->commodites = $this->getInfosFor("commoditesLot");
      $this->rangements = $this->getInfosFor("rangementsLot");
      $this->orientations = $this->getInfosFor("orientationsLot");
      $this->options = $this->getInfosFor("myOptionsLot");
      }
  }

  public function getLot(){
    return $this->modelLot;
  }

  public function getCommodites(){
    return $this->commodites;
  }

  public function getOptions(){
    return $this->options;
  }

  private function getInfosFor($nomTable){
    $sql="SELECT " . str_replace("sLot", "",$nomTable) . " FROM " . $nomTable. " WHERE idLot= " . $this->modelLot->getId();
    $rep=Model::$pdo->query($sql);
    if($rep==false){
      return array();
    }
    $rep=$rep->fetchAll(PDO::FETCH_OBJ);
    $arr=array();
    foreach ($rep as $value) {
      $nomChamp=str_replace("sLot", "",$nomTable);
      array_push($arr, $value->$nomChamp);
    }
    return $arr;
  }

  public static function searchDeep($typesBien,$nombrePieces,$dataCheckBox,$dataPost,$page){
   if(!array_filter($typesBien) && !array_filter($nombrePieces) && !array_filter($dataCheckBox) && !array_filter($dataPost)){
      $sql="select * from lot";
    }else{
      $sql=ModelLotApprofondi::getSqlForDeepSearch($typesBien,$nombrePieces,$dataCheckBox,$dataPost);
    }
    $sql=$sql." LIMIT " . (($page-1)*15) . ", 15";
    $req_prep = Model::$pdo->prepare($sql);

    $values = ModelLotApprofondi::getTableauPrep($typesBien,$nombrePieces,$dataCheckBox,$dataPost);

    $req_prep->execute($values);
    if($req_prep==false){
      return array();
    }
    $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelLot');
    return $req_prep->fetchAll();
  }

  private static function getTableauPrep($typesBien,$nombrePieces,$dataCheckBox,$dataPost){
    $values = ModelLot::getTableauPrep($dataPost);

    $i=1;
    foreach ($typesBien as  $tb) {
      $values["typeDeBien".$i]=$tb;
      $i++;
    }

    $i=1;
    foreach ($nombrePieces as  $np) {
      $values["nombrePiece".$i]=$np;
      $i++;
    }

    foreach ($dataCheckBox as $nomTable => $arrCategorie) {
      if(count($arrCategorie)!=0){
        $i=1;
        foreach ($arrCategorie as  $value) {
          $values[str_replace("sLot", "",$nomTable) . $i]= $value;
          $i++; 
        }
      }
    } 
    return $values;
  }


  public static function getSqlForDeepSearch($typesBien,$nombrePieces,$dataCheckBox,$dataPost){
    $sql=ModelLot::getSqlSearch($dataPost);

    $isFirst=strlen($sql)==23;
    $firstTypeBien=true;
    $i=1;
    foreach ($typesBien as  $value) {
      if($isFirst){
        $sql=$sql." typeDeBien = :typeDeBien".$i;
        $isFirst=false;
        $firstTypeBien=false;
      }
      else if($firstTypeBien){
        $sql=$sql." and typeDeBien = :typeDeBien".$i; 
        $firstTypeBien=false;
      }else{
        $sql=$sql." or typeDeBien = :typeDeBien".$i; 
      }
      $i++;
    }

    $firstNombrePieces=true;
    $i=1;
    foreach ($nombrePieces as  $value) {
      if($isFirst){
        $sql=$sql." nombrePiece = :nombrePiece".$i;
        $isFirst=false;
        $firstNombrePieces=false;
      }
      else if($firstNombrePieces){
        $sql=$sql." and nombrePiece = :nombrePiece".$i; 
        $firstNombrePieces=false;
      }else{
        $sql=$sql." or nombrePiece = :nombrePiece".$i; 
      }
      $i++;
    }

    foreach ($dataCheckBox as $nomTable => $arrCategorie) {
      if(count($arrCategorie)!=0){
        $i=1;
        $sqlTable="";
        foreach ($arrCategorie as  $value) {
          if($isFirst){
            $sqlTable=$sqlTable." id IN ";
            $isFirst=false;
          }else{
            $sqlTable=$sqlTable." AND ID IN  ";
          }
          $sqlTable=$sqlTable."( select idLot from ". $nomTable . " where ".str_replace("sLot", "",$nomTable)." = :" .  str_replace("sLot", "",$nomTable) . $i . ")";
         $i++; 
        }
        $sql=$sql.$sqlTable;
      }
    } 
    return $sql;
  }

  public static function getNbLotRecherche($typesBien,$nombrePieces,$dataCheckBox,$dataPost){
    if(!array_filter($typesBien) && !array_filter($nombrePieces) && !array_filter($dataCheckBox) && !array_filter($dataPost)){
      $sql="select count(*) as nbLot from lot";
    }else{
      $sql="select count(*) as nbLot from ( " . ModelLotApprofondi::getSqlForDeepSearch($typesBien,$nombrePieces,$dataCheckBox,$dataPost) . " ) as recherche ";
    }
    $req_prep = Model::$pdo->prepare($sql);
    $values = ModelLotApprofondi::getTableauPrep($typesBien,$nombrePieces,$dataCheckBox,$dataPost);

    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    $tab_lot= $req_prep->fetchAll();
    return $tab_lot[0]->nbLot;
  }

  public static function getAllCategorie($categorie){
    $sql="SELECT " . $categorie . " FROM " . $categorie;
    $rep=Model::$pdo->query($sql);
    return $rep->fetchAll(PDO::FETCH_OBJ); 
  }

  public static function getAllTypesBiens(){ return ModelLotApprofondi::getAllCategorie("typeDeBien"); }

  public static function getAllTypesPieces(){ return ModelLotApprofondi::getAllCategorie("typeDePieces"); }

  public static function getAllCommodites(){ return ModelLotApprofondi::getAllCategorie("commodites"); }

  public static function getAllTypesRangements(){ return ModelLotApprofondi::getAllCategorie("rangement"); }

  public static function getAllOrientations(){ return ModelLotApprofondi::getAllCategorie("orientation"); }

  public static function getAllOptions(){ return ModelLotApprofondi::getAllCategorie("options"); }

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