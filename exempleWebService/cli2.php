<?php
echo "rrrrrrr";
try
{
  $clientSOAP = new SoapClient( null,
    array (
      'uri' => 'http://srv.priamftp.fr/ws2/srv2.php',
      'location' => 'http://srv.priamftp.fr/ws2/srv2.php',
      'trace' => 1,
      'exceptions' => 0
  ));

  $ret = $clientSOAP->__call('hello', array());
  echo $ret;

  echo '<br />';

  $ret = $clientSOAP->__call('donne', array('i'=>5));
  echo $ret;
  echo '<br />';

  $ret = $clientSOAP->__call('listehuissier', array('ident'=>'f'));
  echo $ret;
  echo '<br />';


  $ret = $clientSOAP->__call('getModule', array('ident'=>''));
  echo $ret;
  
}
catch(SoapFault $f)
{
  echo $f;
}

?>
