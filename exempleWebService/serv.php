<?php
class Serv
{

	private $user="nseg_priam";
	private $pwd="verbatim";
	private $host="nseg.myd.infomaniak.com";
	protected $bdd="nseg_test1";

  function NewOperation($i,$t)
  {
    return $i." dddd ".$t;
  }
  function donne($i)
  {
    return $i;
  }
  function hello()
  {
    return "hello  ffff";
  }
	function listeHuissier2($ident)
	{
		$result = array();
		$link = mysql_connect($this->host, $this->user, $this->pwd);
		$ret = "";
		if($link)
		{
			if(mysql_select_db($this->bdd))
			{
				$sql = "select * from huissier where denomination like '%$ident%'";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				if(1 <= mysql_num_rows($req ))
				{
					while ($row=mysql_fetch_assoc($req))
						$result[] = array('identifiant' => $row['cle'],'denomination' => $row['denomination']);
				}
				mysql_free_result($req);
			}
			mysql_close();
		}

		$ret= "-nbResult-".count($result)."-/nbResult-";
		foreach ($result as $key => $value) {
			$ret .= "-Result-";
			foreach ($value as $key2 => $value2) 
				$ret .= "-".$key2."-".$value2."-/".$key2."-";
			$ret .= "-/Result-";
		}

		return $ret;
	}
  
	function listeHuissier($ident)
	{
		$result = array();
		$link = mysql_connect($this->host, $this->user, $this->pwd);
		if($link)
		{
			if(mysql_select_db($this->bdd))
			{
				$sql = "select * from huissier where denomination like '%$ident%'";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				if(1 <= mysql_num_rows($req ))
				{
					while ($row=mysql_fetch_assoc($req))
						$result[] = array('identifiant' => $row['cle'],'denomination' => $row['denomination']);
				}
				mysql_free_result($req);
			}
			mysql_close();
		}

		
		$xml = new SimpleXMLElement('<retour/>');
		$xml->addChild('nbHuissier' ,count($result));
		foreach ($result as $key => $value) {
			$xml2 = $xml->addChild('Huissier');
			foreach ($value as $key2 => $value2) 
				$xml2->addChild($key2 ,$value2);
		}	
		
		return $xml->asXML();	
	}
  
	function getLibEtude($ident)
	{
		$retVal="";
		$link = mysql_connect($this->host, $this->user, $this->pwd);
		if(!$link)
			$retVal = "ERREUR: CONNEXION DATABASE IMPOSSIBLE";
		else
		{
			if(mysql_select_db($this->bdd))
			{
				$sql = "select * from huissier where cle='$ident'";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				if(1 == mysql_num_rows($req ))
				{
					$data = mysql_fetch_array($req);
					$retVal =$data['denomination'];
				}
				mysql_free_result($req);
			}
			else
				$retVal = "ERREUR:CONNEXION TABLE IMPOSSIBLE";
			mysql_close();
		}
		return $retVal;
	}


	function majHuissier($ident,$nom)
	{
		$result ="";
		$link = mysql_connect($this->host, $this->user, $this->pwd);
		if($link)
		{
			if(mysql_select_db($this->bdd))
			{
				$sql = "delete from huissier where cle='$ident'";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				$sql = "INSERT INTO `huissier` (`cle`, `denomination`) VALUES ('$ident', '$nom')";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				$sql = "select * from huissier where cle='$ident'";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				if(1 == mysql_num_rows($req ))
				{
					$data = mysql_fetch_array($req);
					$result =$data['denomination'];
				}
				mysql_free_result($req);
			}

		}
		$ret =  $result;
		return $ret;
	}

	function getModule($ident)
	{
		$result = array();
		$link = mysql_connect($this->host, $this->user, $this->pwd);
		if($link)
		{
			if(mysql_select_db($this->bdd))
			{
				$sql = "select * from module where huissier = '$ident'";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				if(1 <= mysql_num_rows($req ))
				{
					while ($row=mysql_fetch_assoc($req))
						$result[] = array('lib' => $row['lib'],'etat' => $row['etat']);
				}
				mysql_free_result($req);
			}
			mysql_close();
		}

		$xml = new SimpleXMLElement('<retour/>');
		$xml->addChild('nbModule' ,count($result));
		foreach ($result as $key => $value) {
			$xml2 = $xml->addChild('Module');
			foreach ($value as $key2 => $value2) 
				$xml2->addChild($key2 ,$value2);
		}	
		
		return $xml->asXML();	
	}
	
	function majModule($ident,$lib,$etat)
	{
		$result ="";
		$link = mysql_connect($this->host, $this->user, $this->pwd);
		if($link)
		{
			if(mysql_select_db($this->bdd))
			{
				$sql = "delete from module where huissier='$ident' and lib ='$lib'" ;
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				$sql = "INSERT INTO `module` (`huissier`, `lib`,`etat`) VALUES ('$ident', '$lib','$etat')";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				$sql = "select * from module where huissier='$ident' and lib='$lib'";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				if(1 == mysql_num_rows($req ))
				{
					$data = mysql_fetch_array($req);
					$result =$data['etat'];
				}
				mysql_free_result($req);
			}

		}
		$ret =  $result;
		return $ret;
	}
	function majPoste($ident,$qui,$log,$mac,$os,$office,$resol,$resolm,$ip,$antivir,$newresol)
	{
		$result ="M.A.J";
		$link = mysql_connect($this->host, $this->user, $this->pwd);
		if($link)
		{
		if(mysql_select_db($this->bdd))
			{
				$sql = "select id from postes where etude='$ident' and mac='$mac' and log = '$log'";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				if(1 != mysql_num_rows($req ))
				{
					$result = "Nouveau";
					$sql = "delete from postes where etude='$ident' and mac='$mac' and log = '$log'" ;
					$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
					$sql = "INSERT INTO `postes` (`etude`, `mac`,`log`) VALUES ('$ident', '$mac','$log')";
					$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				}
				$sql = "select id from postes where etude='$ident' and mac='$mac' and log = '$log'";
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				if(1 == mysql_num_rows($req ))
				{
					$data = mysql_fetch_array($req);
					$id = $data['id'];

					$sql = "update `postes` set `qui`='$qui', `log`='$log',`os`='$os',`office`='$office',`resol`='$resol',`resolm`='$resolm' ,`newresol`='$newresol' where id = $id";
					$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
					$sql = "update `postes` set `ip`='$ip', `antivir`='$antivir' where id=$id";
					$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
				}
				mysql_free_result($req);
			}
		}
		$ret =  $result;
		return $ret;

	}

		function getHash($rep)
	{
		$retVal="";
		$filename ="../../MAJ/winpriam/".$rep."/priamw.exe";

		if(file_exists( $filename ))
			$retVal = md5_file ($filename);

		return $retVal;
	}
	
function majPack($ident,$nom,$qui,$log,$erreur,$datec)
	{
		$result ="majpack";
		$link = mysql_connect($this->host, $this->user, $this->pwd);
		if($link)
		{
			if(mysql_select_db($this->bdd))
			{
				$sql ="INSERT INTO `pack_fichier` (`id`, `etude`, `qui`, `log`, `erreur`,`date_op`) VALUES ('$ident','$nom','$qui','$log','$erreur','$datec')";				
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());				
			}

		}
		$ret =  $result;
		return $ret;
	}

function majHuissierDpo($ident,$qui,$mail)
	{
		$result ="M.A.J";
		$link = mysql_connect($this->host, $this->user, $this->pwd);
		if($link)
		{
			if(mysql_select_db($this->bdd))
			{
				$sql ="INSERT INTO `dpoetude` (`id`, `dpo`, `mail`) VALUES ('$ident','$qui','$mail')";				
				$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());				
			}

		}
		$ret =  $result;
		return $ret;
	}

}
?>
