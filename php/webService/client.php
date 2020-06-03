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

  $ret = $clientSOAP->__call('coucou', array());
  echo $ret;
}
catch(SoapFault $e)
{
  echo $e;
}

?>