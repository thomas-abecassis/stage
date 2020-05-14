<?php
require_once File::build_path(array("model", "Model.php"));
require_once File::build_path(array("lib", "Security.php"));

class ModelUtilisateur extends Model{

  private $login;
  private $nom;
  private $prenom;
  private $mdp;
  private $admin;
  private $nonce;

  protected static $object = "utilisateur";
  protected static $primary='login';

  public function __construct($l = NULL, $n = NULL, $p = NULL, $m = NULL, $a = NULL,$nonce = NULL ) {
    if (!is_null($l) && !is_null($n) && !is_null($p) && !is_null($m) && !is_null($a) && !is_null($nonce)) {
      // Si aucun de $m, $c et $i sont nuls,
      // c'est forcement qu'on les a fournis
      // donc on retombe sur le constructeur à 3 arguments
      $this->login = $l;
      $this->nom = $n;
      $this->prenom = $p;
      $this->mdp = $m;
      $this->admin = $a;
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