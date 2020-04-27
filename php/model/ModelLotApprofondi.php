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
      // Si aucun de $m, $c et $i sont nuls,
      // c'est forcement qu'on les a fournis
      // donc on retombe sur le constructeur à 3 arguments
      $this->modelLot = $modelLot;
      $this->typesDePieces = $this->getInfosFor("typeDePiecesLot");
      $this->commodites = $this->getInfosFor("commoditesLot");
      $this->rangements = $this->getInfosFor("rangementsLot");
      $this->orientations = $this->getInfosFor("orientationsLot");
      $this->options = $this->getInfosFor("myOptionsLot");
      }
  }

  public function getInfosFor($nomTable){
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

 // a securiser
  public static function searchDeep($typesBien,$nombrePieces,$dataCheckBox,$dataPost){
    if(!array_filter($typesBien) && !array_filter($nombrePieces) && !array_filter($dataCheckBox) && !array_filter($dataPost)){
      return Modellot::selectAll();
    }
    $sql=ModelLotApprofondi::getSqlForDeepSearch($typesBien,$nombrePieces,$dataCheckBox,$dataPost);
    $rep=Model::$pdo->query($sql);
    if($rep==false){
      return array();
    }
    $rep->setFetchMode(PDO::FETCH_CLASS, 'ModelLot');
    return $rep->fetchAll();
  }

  // a securiser
  public static function getSqlForDeepSearch($typesBien,$nombrePieces,$dataCheckBox,$dataPost){
    $sql=ModelLot::getSqlSearch($dataPost);
    $isFirst=strlen($sql)==23;
    if(count($typesBien)!=0){
      if($isFirst){$sql=$sql." typeDeBien = \"".$typesBien[0]."\"";}
      else{$sql=$sql." and typeDeBien = \"".$typesBien[0]."\""; }
      $isFirst=false;
    }
    if(count($nombrePieces)!=0){
      if($isFirst){$sql=$sql."nombrePiece= ".$nombrePieces[0]; }
      else{$sql=$sql." and nombrePiece= ".$nombrePieces[0];}
      $isFirst=false;
    }

    foreach ($dataCheckBox as $nomTable => $arrCategorie) {
      if(count($arrCategorie)!=0){
        $sqlTable="";
        foreach ($arrCategorie as  $value) {
          if($isFirst){
            $sqlTable=$sqlTable." id IN ";
            $isFirst=false;
          }else{
            $sqlTable=$sqlTable." AND ID IN  ";
          }

          $sqlTable=$sqlTable."( select idLot from ". $nomTable . " where ".str_replace("sLot", "",$nomTable)." = \"" .  $value . "\")  ";
          
        }
        $sql=$sql.$sqlTable;
      }
    }
    return $sql;
  }

  public static function getAllCategorie($categorie){
    $sql="SELECT " . $categorie . " FROM " . $categorie;
    $rep=Model::$pdo->query($sql);
    return $rep->fetchAll(PDO::FETCH_OBJ); 
  }

  public static function getAllTypesBiens(){
    return ModelLotApprofondi::getAllCategorie("typeDeBien");
  }

    public static function getAllTypesPieces(){
    return ModelLotApprofondi::getAllCategorie("typeDePieces");
  }

  public static function getAllCommodites(){
    return ModelLotApprofondi::getAllCategorie("commodites");
  }

  public static function getAllTypesRangements(){
    return ModelLotApprofondi::getAllCategorie("rangement");
  }

  public static function getAllOrientations(){
    return ModelLotApprofondi::getAllCategorie("orientation");
  }

  public static function getAllOptions(){
    return ModelLotApprofondi::getAllCategorie("options");
  }

}
?>

