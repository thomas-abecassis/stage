<?php
require_once('serv.php');
try
{
  $server = new SoapServer(null, array('uri' => 'http://srv.priamftp.fr/ws2/srv2.php'));

  $server->setClass("Serv");
  $server->handle();
}
catch(Exception $e)
{
  echo "Exception: " . $e;
}
?>
