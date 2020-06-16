<?php

require_once File::build_path(array("model", "Model.php"));

class ModelOptionsSite extends Model{

  private $nomOption;
  private $valeur;
  protected static $object = "optionsSite";
  protected static $primary='nomOption';

  public function __construct($nomOption = NULL, $valeur = NULL) {
    if (!is_null($nomOption)  && !is_null($valeur)) {
      $this->nomOption = $nomOption;
      $this->valeur = $valeur;
    }
  }

  public function getValeur(){
    return $this->valeur;
  }
}