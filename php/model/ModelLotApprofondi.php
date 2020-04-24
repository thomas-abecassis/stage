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
      $this->typesDePieces = $this->getInfosFor("typeDePiecesLot", "typeDePiece");
      //$this->commodites = $commodites;
      //$this->rangements = $rangements;
      //$this->orientations = $orientations;
      //$this->options = $options;
    }
  }

  public function getInfosFor($nomTable,$nomChamp){
    $sql="SELECT " . $nomChamp . " FROM " . $nomTable. " WHERE idLot= " . $this->modelLot->getId();
    $rep=Model::$pdo->query($sql);
    $rep=$rep->fetchAll(PDO::FETCH_OBJ);
    $arr=array();
    foreach ($rep as $value) {
      array_push($arr, $value->$nomChamp);
    }
    return $arr;
  }

}
?>

