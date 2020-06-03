<?php
require_once File::build_path(array("model", "Model.php"));
require_once File::build_path(array("lib", "Security.php"));

class ModelUtilisateur extends Model{

  private $login;
  private $nom;
  private $prenom;
  private $mdp;
  private $role;
  private $nonce;

  protected static $object = "utilisateur";
  protected static $primary='login';

  public function __construct($l = NULL, $n = NULL, $p = NULL, $m = NULL, $r = NULL,$nonce = NULL ) {
    if (!is_null($l) && !is_null($n) && !is_null($p) && !is_null($m) && !is_null($r) && !is_null($nonce)) {
      // Si aucun de $m, $c et $i sont nuls,
      // c'est forcement qu'on les a fournis
      // donc on retombe sur le constructeur à 3 arguments
      $this->login = $l;
      $this->nom = $n;
      $this->prenom = $p;
      $this->mdp = $m;
      $this->role = $r;
      $this->nonce = $nonce;
    }
  }

  public function getLogin(){
    return $this->login;
  }

  public function getNom(){
    return $this->nom;
  }

  public function getPrenom(){
    return $this->prenom;
  }

  public function getRole(){
    return $this->role;
  }

  public function isSimpleUtilisateur(){
    return $this->role==0;
  }

  public function isCommercial(){
    return $this->role==1;
  }

  public function isAdmin(){
    return $this->role==2;
  }

  public function isSuperAdmin(){
    return $this->role==3;
  }

  public function getRoleStr(){
      if($this->isSimpleUtilisateur()){
        return "simple utilisateur";
      }
      if($this->isCommercial()){
        return "commercial";
      }
      return "admin";
  }

  public function getMdp(){
    return $this->mdp;
  }

  public function getNonce(){
    return $this->nonce;
  }

  public function setNonce(){
    $this->nonce=NULL;
  }

  public function getTab(){
    return get_object_vars($this);
  }

  public static function selectAllByPage($page){
    $sql = "select * from utilisateur where role!=3 limit " . (($page-1)*30) . ", 30 ";
    $req_prep = Model::$pdo->query($sql);

    $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelUtilisateur");
    $tab_utilisateur= $req_prep->fetchAll();
    return $tab_utilisateur;
  }

  public static function selectByLoginAndPage($login,$page){
     $sql = "SELECT * from utilisateur WHERE lower(login) LIKE lower(:tag) and role !=3 limit " . (($page-1)*30) . ", 30 ";
      // Préparation de la requête
      $req_prep = Model::$pdo->prepare($sql);

      $values = array(
          "tag" => $login . "%",
      );
 
      $req_prep->execute($values);
      if($req_prep==false){
        return false;
      }
      $req_prep->setFetchMode(PDO::FETCH_CLASS,"ModelUtilisateur");
      $tab_utilisateur = $req_prep->fetchAll();
      return $tab_utilisateur;
  }

  public static function count(){
    $sql = "SELECT count(*) as nb from utilisateur where role!=3";
    // Préparation de la requête
 
    $req_prep=Model::$pdo->query($sql);
    $req_prep->setFetchMode(PDO::FETCH_OBJ);
    $tab_voit = $req_prep->fetchAll();
     return $tab_voit[0]->nb;
  }

  public static function countByName($login){
      $sql = "SELECT count(*) as nb from utilisateur WHERE lower(login) LIKE lower(:tag) and role!=3";
      // Préparation de la requête
      $req_prep = Model::$pdo->prepare($sql);

      $values = array(
          "tag" => $login . "%",
      );
 
      $req_prep->execute($values);
      $req_prep->setFetchMode(PDO::FETCH_OBJ);
      $tab_voit = $req_prep->fetchAll();
     return $tab_voit[0]->nb;
  }

  static public function checkPassword($login,$mdp){
    $u=ModelUtilisateur::select($login);
    if($u==false){
      return $u;
    }
    if(strcmp($u->getMdp(),Security::chiffrer($mdp))==0){
      return true;
    }
    return false;
  }
}
?>