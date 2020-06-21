<?php
echo "debut";

class authentificateur{
  public $login;
  public $password;
 
  public function __construct($l, $p){
    $this->login = $l;
    $this->password = $p;        
  }
}

try
{
  //ini_set("soap.wsdl_cache_enabled", 0);
  //$service=new SoapClient("http://localhost/stage/php/lib/webservice.xml?wsdl");

  $clientSOAP = new SoapClient( null,
      array (
        'uri' => 'http://localhost:8080/stage/php/lib/soap.php',
        'location' => 'http://localhost:8080/stage/php/lib/soap.php',
        'trace' => 1,
        'exceptions' => 0
    ));

  //var_dump($clientSOAP->__getFunctions());

  //$ret = $service->__call('supprimeLots',array());
  //echo $ret;

  $auth=new authentificateur("test","toast");
  $soapHeaders[] = new SoapHeader("http://localhost:8080", 'authentification', $auth);

  $clientSOAP->__setSoapHeaders($soapHeaders);
  /*
  $ret = $clientSOAP->__call('supprimerUnLot', array("123"));
  echo $ret;*/
$ret = $clientSOAP->__call('supprimerUnLot', array("test2"));
  $ret = $clientSOAP->__call('creerLot', array("test2", "Montpellier", "123", "123", "maison", "123", "123", "123","toast", "111", array("Commodité(s)"=>array("alarme"))));
  //$ret = $clientSOAP->__call('mettreAJourLot', array("test2", "Montpellier", "12113", "123", "maison", "123", "123", "123", array(array("valeur"=>"appartement", "Option(s)"=>"gardien"))));
  
  
  echo $clientSOAP->__getLastResponse();


  /*$path = '../../image/fond.jpg';
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path);
  $base64 = base64_encode($data);
  $ret= $clientSOAP->__call('saveImage', array("100",$base64));
  echo $ret;*/
}
catch(SoapFault $e)
{
  echo $e;
}