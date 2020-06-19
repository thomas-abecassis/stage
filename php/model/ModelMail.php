<?php
require_once File::build_path(array("model", "Model.php"));

class ModelMail extends Model{

  protected static $object = "mailLot";
  protected static $primary='id';

  private $id;
  private $mail;

  public function __construct($i = NULL, $mail = NULL) {
    if (!is_null($mail)  ) {
      $this->id = $i;
      $this->mail = $mail;
    }
  }

  public function getId(){
    return $this->id;
  }

  public function getTab(){
    return get_object_vars($this);
  }
}
