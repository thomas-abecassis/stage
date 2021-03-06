<?php
require_once File::build_path(array("model", "Model.php"));

class ModelCategories extends Model{

  protected static $object = "categories";
  protected static $primary='id';

  private $id;
  private $categorie;
  private $interface;

  public function __construct($i = NULL, $categorie = NULL, $interface = NULL) {
    if (!is_null($i)  && !is_null($loc) && !is_null($interface) ) {
      $this->id = $i;
      $this->categorie = $categorie;
      $this->interface = $interface;
    }
  }

  public function getId(){
    return $this->id;
  }

  public static function getValeursCategoriesLot($lot){
    $sqlCategories = "select distinct categorie,categories.id from lotCategorie join sousCategorie on lotCategorie.idValeurCategorie=sousCategorie.id join categories on categories.id=sousCategorie.categorieId where idLot=\"".$lot->getLot()->getId()."\""; 
    $rep=Model::$pdo->query($sqlCategories);
    $rep=$rep->fetchAll(PDO::FETCH_OBJ);
    $valeurs=array();
    foreach ($rep as $categorie) {
      $ar=array();
      $sql="select * from lotCategorie join sousCategorie on lotCategorie.idValeurCategorie=sousCategorie.id join categories on categories.id=sousCategorie.categorieId where categorieId=".$categorie->id. "  and idLot=\"" . $lot->getLot()->getId() . "\"";
      $repVal=Model::$pdo->query($sql);
      $repVal=$repVal->fetchAll(PDO::FETCH_OBJ);
      foreach ($repVal as $valeurCategorie) {
        array_push($ar, $valeurCategorie->valeur);
      }
      $valeurs[$categorie->categorie]=$ar;
    }
    return $valeurs;
  }

  public static function getAllValeursCategories(){
    $categories=ModelCategories::selectAll();
    $valeurs=array();
    foreach ($categories as $categorie) {
      $ar=array();
      $sql="select valeur,id from sousCategorie where categorieId=".$categorie->getId();
      $rep=Model::$pdo->query($sql);
      $rep=$rep->fetchAll(PDO::FETCH_OBJ);
      foreach ($rep as $valeurCategorie) {
        array_push($ar, $valeurCategorie);
      }
      $valeurs[$categorie->categorie]=$ar;
    }
    return $valeurs;
  }

  public static function CategorieAndValeurToId($categorie, $valeur){
    $sql="select sousCategorie.id from sousCategorie join categories on categories.id=sousCategorie.categorieId where sousCategorie.valeur= :valeur and categories.categorie= :categorie";

    $req_prep = Model::$pdo->prepare($sql);
    $values = array("valeur"=>$valeur,
                    "categorie"=>$categorie);

    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    $rep= $req_prep->fetchAll();
    if(count($rep)==0){
      return false;
    }
    return $rep[0]->id;
  }

  public static function IdToValeurAndCategorie($id){
  	$sql="select valeur, categorie from sousCategorie join categories on categories.id=sousCategorie.categorieId where sousCategorie.id= :id";

    $req_prep = Model::$pdo->prepare($sql);
    $values = array("id"=>$id);

    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    $rep= $req_prep->fetchAll();


    $tabValeurAndCategorie=array();
    $tabValeurAndCategorie["categorie"]=$rep[0]->categorie;
    $tabValeurAndCategorie["valeur"]=$rep[0]->valeur;
    return $tabValeurAndCategorie;
  }

  public static function arrayIdToValeurAndCategorie($tabId){
    $tabValeurAndCategorie=array();
    for($i=0;$i<count($tabId);$i++){
      $tabValeurAndCategorie[$i]=ModelCategories::IdToValeurAndCategorie($tabId[$i]);
    }
    return $tabValeurAndCategorie;
  }

  public static function arrayCategorieAndValeurToId($tabValeurAndCategorie){
    $tabId=array();
    foreach ($tabValeurAndCategorie as $categorie=>$tabCategorie) {
      foreach ($tabCategorie as $valeur) {
        $id=ModelCategories::CategorieAndValeurToId($categorie,$valeur);
        if($id===false){
          return false;
        }
        array_push($tabId,$id);
      }
    }
    return $tabId;
  }

  public static function searchId($arrayValeurs,$id){
    foreach ($arrayValeurs as $key=>$tab) {
      foreach ($tab as $v) {
        if($id==$v->id){
          return $v;
        }
      }
    }
  }
  
}
