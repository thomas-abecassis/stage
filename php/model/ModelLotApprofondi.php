<?php

require_once File::build_path(array("model", "Model.php"));
require_once File::build_path(array("model", "ModelLot.php"));
require_once File::build_path(array("model", "ModelCategories.php"));

class ModelLotApprofondi {
   
  private $modelLot;
  private $plus;
      
  public function __construct($modelLot = NULL) {
    if (!is_null($modelLot) ) {
      $this->modelLot = $modelLot;
      $this->plus=ModelCategorie::getValeursCategoriesLot($this);
      }
  }

  /*public function getnom(){
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
  }*/

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


  public static function searchDeep($dataCheckBox,$dataPost,$typesBien,$nombrePieces,$page){
   if( !array_filter($dataCheckBox) && !array_filter($dataPost) && count($typesBien)==0 && count($nombrePieces)==0){
      $sql="select lot.id,nom as localisation,surface, loyer, description, informationsCommercial, typeDeBien, nombreDePieces from lot JOIN villesFrance on villesFrance.id=lot.localisation ";   
    }else{
      $sql=ModelLotApprofondi::getSqlForDeepSearch($dataCheckBox,$dataPost,$typesBien,$nombrePieces);
    }
    $sql=$sql." group by id LIMIT " . (($page-1)*15) . ", 15";
    $req_prep = Model::$pdo->prepare($sql);

    $values = ModelLotApprofondi::getTableauPrep($dataPost,$typesBien,$nombrePieces);
    $req_prep->execute($values);
    if($req_prep==false){
      return array();
    }
    $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelLot');
    //return $req_prep->fetchAll();
    $test=$req_prep->fetchAll();
    return $test; 
    return ModelLotApprofondi::lotsToLotsApprofondi($test); //Je peux optimiser ça en utilisant de l'ajax

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

  public static function lotsToLotsApprofondi($tabLots){
    $valeurs=ModelCategorie::getAllValeursCategories();
    $tabLotsApprofondis = array();
    foreach ($tabLots as $lot) {
      array_push($tabLotsApprofondis, ModelLotApprofondi::lotToLotApprofondi($lot,$valeurs));
    }
    return $tabLotsApprofondis;
  }

  public static function getSqlForDeepSearch($dataCheckBox,$dataPost,$typesBien,$nombrePieces){
    $sql=ModelLot::getSqlSearch($dataPost);

    if(arrayContentIsEmpty($dataPost) && (count($typesBien)!==0 || count($nombrePieces)!==0)) 
      $sql=$sql.' where ';

    if(count($typesBien)!==0 || count($nombrePieces)!==0){ 
      if(!arrayContentIsEmpty($dataPost))
        $sql=$sql . " and ";
      $sql=$sql.'(';
    }

    for ($i=0; $i<count($typesBien);$i++) {
      $sql=$sql . " typeDeBien =:typeDeBien".$i;
      if($i!==count($typesBien)-1)
        $sql=$sql.' or '; 
    }

    if(count($typesBien)!==0 && count($nombrePieces)!==0) 
      $sql=$sql.' or ';

    for ($i=0; $i<count($nombrePieces);$i++) {
      $nombreDePieces= $nombrePieces[$i];
      if(!strpos($nombreDePieces, " et plus")===false ){ //strpos peut renvoyer 0 donc on utilise === false
        $sql=$sql . " nombreDePieces >= :nombreDePieces".$i;
      }else{
        $sql=$sql . " nombreDePieces = :nombreDePieces".$i;
      }
      if($i!==count($nombrePieces)-1)
        $sql=$sql.' or '; 
    }

    if(count($typesBien)!==0 || count($nombrePieces)!==0) 
      $sql=$sql.')';

    if(!count($dataCheckBox)) return $sql;

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

  public static function getNbLotRecherche($dataCheckBox,$dataPost,$typesBien,$nombrePieces){
    if( !array_filter($dataCheckBox) && !array_filter($dataPost)){
      $sql="select count(*) as nbLot from lot";
    }else{
      $sql="select count(*) as nbLot from ( " . ModelLotApprofondi::getSqlForDeepSearch($dataCheckBox,$dataPost,$typesBien,$nombrePieces) . " ) as recherche ";
    }
    $req_prep = Model::$pdo->prepare($sql);
    $values = ModelLotApprofondi::getTableauPrep($dataPost,$typesBien,$nombrePieces);

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

  public static function getTableauPrep($dataPost,$typesBien,$nombrePieces){
    $values = ModelLot::getTableauPrep($dataPost);

    for ($i=0; $i<count($typesBien);$i++) {
      $values["typeDeBien".$i]=$typesBien[$i];
    }

    for ($i=0; $i<count($nombrePieces);$i++) {
      $values["nombreDePieces".$i]=intval (str_replace(" et plus", "", $nombrePieces[$i]));
    }

    return $values;
  }

}
?>