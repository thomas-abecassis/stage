<?php
require_once('serv.php');
try
{
  $server = new SoapServer(null, array('encoding'=>'UTF-8','uri' => 'localhost'));

  $server->setClass("Serv");
  $server->handle();

  /*$server->wsdl->addComplexType(
	'alerteType',
	'complexType',
	'struct',
	'all',
	'',
	array('loginUtilisateur' => array('name'=>'articleId', 'type'=>'xsd:int'),
	      'tabSimple' => array('name'=>'heading', 'type'=>'xsd:string'),
	      'tabCheckBox' => array('name'=>'text', 'type'=>'xsd:string'),
	      'tabTypeDeBien' => array('name'=>'text', 'type'=>'xsd:string'),
	      'tabNombreDePieces' => array('name'=>'text', 'type'=>'xsd:string'),
	      'nom' => array('name'=>'text', 'type'=>'xsd:string'),
	      'idAlerte' => array('name'=>'text', 'type'=>'xsd:string')
	     )
	);

	$server->register("getAllAlertesActive", array(), array('return'=>'tns:alerteType'), $namespace, $namespace."#getAllAlertesActive", 'rpc', 'encoded', 'Test function');*/
}
catch(Exception $e)
{
  echo "Exception: " . $e;
}