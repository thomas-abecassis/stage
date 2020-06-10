<?php
require_once File::build_path(array("model", "Model.php"));

class ModelCategorie{

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

  public static function getAllCategories(){
    $sql="SELECT * FROM categories";
    $rep=Model::$pdo->query($sql);
    return $rep->fetchAll(PDO::FETCH_OBJ);
  }

  public static function getAllValeursCategories(){
    $categories=ModelCategorie::getAllCategories();
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

  private static function CategorieAndValeurToId($categorie, $valeur){
    $sql="select sousCategorie.id from sousCategorie join categories on categories.id=sousCategorie.categorieId where sousCategorie.valeur= :valeur and categories.categorie= :categorie";

    $req_prep = Model::$pdo->prepare($sql);
    $values = array("valeur"=>$valeur,
                    "categorie"=>$categorie);

    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    $rep= $req_prep->fetchAll();

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
      $tabValeurAndCategorie[$i]=ModelCategorie::IdToValeurAndCategorie($tabId[$i]);
    }
    return $tabValeurAndCategorie;
  }

  public static function arrayCategorieAndValeurToId($tabValeurAndCategorie){
    $tabId=array();
    for($i=0;$i<count($tabValeurAndCategorie);$i++){
      $tabId[$i]=ModelCategorie::CategorieAndValeurToId($tabValeurAndCategorie[$i]["categorie"],$tabValeurAndCategorie[$i]["valeur"]);
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
?>