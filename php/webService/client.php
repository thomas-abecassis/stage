<?php
echo "debut";
try
{
  $clientSOAP = new SoapClient( null,
    array (
      'uri' => 'http://localhost/stage/php/webservice/soap.php',
      'location' => 'http://localhost/stage/php/webservice/soap.php',
      'trace' => 1,
      'exceptions' => 0
  ));

  $ret = $clientSOAP->__call('creerLot', array("124", "Montpellier", "123", "123", "maison", "123", "123", "123", "123", "123", "123", "123", "123"));
  echo $ret;
}
catch(SoapFault $e)
{
  echo $e;
}

?>