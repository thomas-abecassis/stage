<?php
require_once('serv.php');
try
{
  $server = new SoapServer(null, array('uri' => 'localhost'));

  $server->setClass("Serv");
  $server->handle();
}
catch(Exception $e)
{
  echo "Exception: " . $e;
}
?>