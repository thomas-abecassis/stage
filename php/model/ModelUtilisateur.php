<?php
require_once File::build_path(array("model", "Model.php"));
require_once File::build_path(array("lib", "Security.php"));

class ModelUtilisateur extends Model{

  private $login;
  private $nom;
  private $prenom;
  private $mdp;
  private $role;
  private $dateDerniereConnexion;

  protected static $object = "utilisateur";
  protected static $primary='login';

  public function __construct($l = NULL, $n = NULL, $p = NULL, $m = NULL, $r = NULL, $dateDerniereConnexion = NULL) {
    if (!is_null($l) && !is_null($n) && !is_null($p) && !is_null($m) && !is_null($r) && !is_null($dateDerniereConnexion)) {
      // Si aucun de $m, $c et $i sont nuls,
      // c'est forcement qu'on les a fournis
      // donc on retombe sur le constructeur à 3 arguments
      $this->login = $l;
      $this->nom = $n;
      $this->prenom = $p;
      $this->mdp = $m;
      $this->role = $r;
      $this->dateDerniereConnexion = $dateDerniereConnexion;
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

  public function getDate(){
    return $this->dateDerniereConnexion;
  }

  public function getMdp(){
    return $this->mdp;
  }

  public function setMdp($mdp){
    $this->mdp=Security::chiffrer($mdp);
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

    $values = array("tag" => "%" . $login . "%");
 
    $req_prep->execute($values);
    if($req_prep==false){
      return false;
    }
    $req_prep->setFetchMode(PDO::FETCH_CLASS,"ModelUtilisateur");
    $tab_utilisateur = $req_prep->fetchAll();
    return $tab_utilisateur;
  }

  public static function selectBySemainesSansConnexion($nombreDeSemaine){
    //retourne les utilisateurs sans role qui ne se sont pas connecter pendant $nombreSemaine semaine.
    $sql = "SELECT * from utilisateur WHERE dateDerniereConnexion <  DATE_ADD(NOW(), INTERVAL :nombreDeSemaine DAY) ";
      // Préparation de la requête
    $req_prep = Model::$pdo->prepare($sql);

    $values = array("nombreDeSemaine" =>"-".$nombreDeSemaine*7);
 
    $req_prep->execute($values);
    if($req_prep==false){
      return false;
    }
    $req_prep->setFetchMode(PDO::FETCH_CLASS,"ModelUtilisateur");
    $tab_utilisateur = $req_prep->fetchAll();
    return $tab_utilisateur;
  }

  public static function count(){
    // comme les superadmins n'apparaissent pas dans la liste on ne les compte pas 
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
          "tag" =>"%" . $login . "%",
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
    if($u->getMdp()===Security::chiffrer($mdp)){
      return true;
    }
    return false;
  }
}