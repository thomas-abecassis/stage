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
  ini_set("soap.wsdl_cache_enabled", 0);
  $service=new SoapClient("http://localhost/stage/php/lib/webservice.xml?wsdl");

  var_dump($service->__getFunctions());

  //$ret = $service->__call('supprimeLots',array());
  //echo $ret;

  //$auth=new authentificateur("test","toast");
  //$soapHeaders[] = new SoapHeader("http://localhost", 'authentification', $auth);

  /*$clientSOAP = new SoapClient( null,
    array (
      'uri' => 'http://localhost/stage/php/lib/soap.php',
      'location' => 'http://localhost/stage/php/lib/soap.php',
      'trace' => 1,
      'exceptions' => 0
  ));*/

  //$clientSOAP->__setSoapHeaders($soapHeaders);

  //$ret = $clientSOAP->__call('creerLot', array("124", "Montpellier", "123", "123", "maison", "123", "123", "123", array("salle de bain"), array("commodites"), array("cave"), array("sud"), array("gardien")));
  //$ret= $clientSOAP->__call('coucou', array());
  //echo $ret;

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
?>