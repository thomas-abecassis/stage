<?php
require_once File::build_path(array("model", "Model.php"));

class ModelTelephone extends Model{

  protected static $object = "telephoneLot";
  protected static $primary='id';

  private $id;
  private $telephone;

  public function __construct($i = NULL, $telephone = NULL) {
    if (!is_null($telephone)  ) {
      $this->id = $i;
      $this->telephone = $telephone;
    }
  }

  public function getId(){
    return $this->id;
  }

  public function getTab(){
    return get_object_vars($this);
  }
}
