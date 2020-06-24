<?php
class Conf{
static private $debug = True; 
    
  static public function getDebug() {
    return self::$debug;
  }

  static private $databases = array(
    'hostname' => 'webinfo.iutmontp.univ-montp2.fr',
    'database' => 'abecassist',
    'login' => 'abecassist',
    'password' => 'iutthomas2019'
  );
   
  static public function getLogin() {
    return self::$databases['login'];
  }

  static public function getHostName(){
    return self::$databases['hostname'];
  }

  static public function getDatabases(){
    return self::$databases;
  }

  static public function getDatabase(){
    return self::$databases['database'];
  }

  static public function getPassword(){
    return self::$databases['password'];
  }
}