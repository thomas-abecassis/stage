<?php
class serveur {

	function getLibEtude($ident)
	{
		$retVal="";
		$user="priamweb";
		$pwd="verbatim";
		$host="";
		$bdd="webpriam";
		$link = mysql_connect($host, $user, $pwd);
		if(!$link)
			$retVal = "ERREUR: CONNEXION DATABASE IMPOSSIBLE";
		else
		{
			if(mysql_select_db($bdd))
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

        function listeHuissier($ident)
        {
                $result = array();
                $user="priamweb";
                $pwd="verbatim";
                $host="";
                $bdd="webpriam";
                $link = mysql_connect($host, $user, $pwd);
                if($link)
                {
                        if(mysql_select_db($bdd))
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
                $ret =  array('nbHuissier'=> count($result), 'Huissier' => $result);
		return $ret;
        }

       function listeClientEdi($ident)
        {
                $result = array();
                $user="priamweb";
                $pwd="verbatim";
                $host="";
                $bdd="webpriam";
                $link = mysql_connect($host, $user, $pwd);
                if($link)
                {
                        if(mysql_select_db($bdd))
                        {
                                $sql = "select client from cliedi where huissier = '$ident'";
                                $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
                                if(1 <= mysql_num_rows($req ))
                                {
                                        while ($row=mysql_fetch_assoc($req))
                                                $result[] = array('codre' => $row['client']);
                                }
                                mysql_free_result($req);
                        }
                        mysql_close();
                }
                $ret =  array('nbEdi'=> count($result), 'cliedi' => $result);
                return $ret;
        }



	function getBye($prenom, $nom)
	{
		return 'Bye ' . $prenom . ' ' . $nom;
	}

	function NewOperation($valut)
	{
	$result = array();
	$result[] = array('nom' => $valut->nom,'prenom' => $valut->prenom);
	$result[] = array('nom' => 'Killzoneii: ','prenom' => 'Shadow Faluuu');
	$result[] = array('nom' => 'Killzoneii: ','prenom' => 'Shadow Faluuu');

	   $games = array('nbRet'=> count($result), 'RetourVal' => $result);

		return $games;
		}
	
	function MyPutFile($paramFic){
		$messRetour="R_".$paramFic->nom;
		if (!$fichier = fopen('/home/depot/'.$paramFic->nom, 'w'))
			$messRetour="Erreur ".$paramFic->nom."->".base64_decode($paramFic->MonFic);
		else 
		{ 
			$messRetour="Fichier creer";
			$text = base64_decode($paramFic->MonFic);
			fwrite($fichier,$text);
			fclose($fichier);
		}
		return $messRetour;
	}
	
	function SendObservatoireEconomique($oObs)
	{
		$messRetour = "Ok";
                $user="priamweb";
                $pwd="verbatim";
                $host="";
                $bdd="webpriam";
                $link = mysql_connect($host, $user, $pwd);
                if(!$link)
                        $messRetour = "ERREUR: CONNEXION DATABASE IMPOSSIBLE";
                else
                {
                        if(mysql_select_db($bdd))
                        {

                                $sql = "insert into observatoire (IdMessage ,ExternalId ,Nature ,Date ,Heure ,Nom_Editeur ,Licence ,Nom_Logiciel ,Version_Logiciel ,Periode_Extraction ,ENC_Acomptes_debiteurs ,ENC_Provisions_Dem ,REV_Cumul ,REV_Cumul_PS ,VD_Cumul ,PF_Cumul ,PF_Honoraires_Ht ,PF_HHT_Actes ,PF_HHT_DRE_A8 ,PF_HHT_DRE_A10 ,PF_HHT_HC ,PF_HHT_FG ,PF_HHT_FD ,PF_HHT_FDF ,PF_TVA ,PF_TAXES_Forfaitaires ,PF_Debours ,PE_Cumul ,PE_Honoraires_Ht ,PE_HHT_Actes ,PE_HHT_DRE_A8 ,PE_HHT_DRE_A10 ,PE_HHT_HC ,PE_HHT_FG ,PE_HHT_FD ,PE_HHT_FDF ,PE_TVA ,PE_TAXES_Forfaitaires ,PE_Debours ,Cumul_Charges ,Cumul_Charges_Constatees ,Cumul_Charges_Payees ,NB_AE_ST ,NB_AE_NST ,NB_AE_AJ ,NB_AD_ST ,NB_AD_NST ,NB_AD_AJ ,NB_AP ,NB_SIGN ,PB_SIGN ,NB_AEXE ,PB_AEXE ,MT_RE_AM ,MT_RE_JU ,NB_CONSTATS ,PB_CONSTATS ) values ($oObs->IdMessage ,$oObs->ExternalId ,'$oObs->Nature ','$oObs->Date','$oObs->Heure','$oObs->Nom_Editeur','$oObs->Licence','$oObs->Nom_Logiciel ','$oObs->Version_Logiciel ','$oObs->Periode_Extraction ',$oObs->ENC_Acomptes_debiteurs ,$oObs->ENC_Provisions_Dem ,$oObs->REV_Cumul ,$oObs->REV_Cumul_PS ,$oObs->VD_Cumul ,$oObs->PF_Cumul ,$oObs->PF_Honoraires_Ht ,$oObs->PF_HHT_Actes ,$oObs->PF_HHT_DRE_A8 ,$oObs->PF_HHT_DRE_A10 ,$oObs->PF_HHT_HC ,$oObs->PF_HHT_FG ,$oObs->PF_HHT_FD ,$oObs->PF_HHT_FDF ,$oObs->PF_TVA ,$oObs->PF_TAXES_Forfaitaires ,$oObs->PF_Debours ,$oObs->PE_Cumul ,$oObs->PE_Honoraires_Ht ,$oObs->PE_HHT_Actes ,$oObs->PE_HHT_DRE_A8 ,$oObs->PE_HHT_DRE_A10 ,$oObs->PE_HHT_HC ,$oObs->PE_HHT_FG ,$oObs->PE_HHT_FD ,$oObs->PE_HHT_FDF ,$oObs->PE_TVA ,$oObs->PE_TAXES_Forfaitaires ,$oObs->PE_Debours ,$oObs->Cumul_Charges ,$oObs->Cumul_Charges_Constatees ,$oObs->Cumul_Charges_Payees ,$oObs->NB_AE_ST ,$oObs->NB_AE_NST ,$oObs->NB_AE_AJ ,$oObs->NB_AD_ST ,$oObs->NB_AD_NST ,$oObs->NB_AD_AJ ,$oObs->NB_AP ,$oObs->NB_SIGN ,$oObs->PB_SIGN ,$oObs->NB_AEXE ,$oObs->PB_AEXE ,$oObs->MT_RE_AM ,$oObs->MT_RE_JU ,$oObs->NB_CONSTATS ,$oObs->PB_CONSTATS )";
                                $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
                                if(!$req )
                                {
                                        $messRetour = 'ko';
                                }
                                mysql_free_result($req);
                        }
                        else
                                $messRetour = "ERREUR:CONNEXION TABLE IMPOSSIBLE";
                        mysql_close();
                }
                return $messRetour;
        }
        function SendRepertoireActes($oActes)
        {
                $messRetour = "Ok";
                $user="priamweb";
                $pwd="verbatim";
                $host="";
                $bdd="webpriam";
                $link = mysql_connect($host, $user, $pwd);
                if(!$link)
                        $messRetour = "ERREUR: CONNEXION DATABASE IMPOSSIBLE";
                else
                {
                        if(mysql_select_db($bdd))
                        {	
				for($nActes = 0;$nActes < count($oActes->SendRepertoireActesDetailParam);$nActes++)
				{	
					$acte = $oActes->SendRepertoireActesDetailParam[$nActes];
                                        $sql = "insert into actes (IdMessage,ExternalId,Nature,Date,Heure ,Annex,Trimestre,IdSCT,Nom_Editeur,Licence,Nom_Logiciel,Version_Logiciel,Date_Acte,Code_Acte,Nature_Acte,Demandeur,Defendeur,Commune,CodCom ,Kilometre) values ($oActes->IdMessage ,$oActes->ExternalId ,'$oActes->Nature ','$oActes->Date','$oActes->Heure','$oActes->Annex',$oActes->Trimestre,'$oActes->IdSCT','$oActes->Nom_Editeur','$oActes->Licence','$oActes->Nom_Logiciel ','$oActes->Version_Logiciel ','$acte->Date_Acte','$acte->Code_Acte','$acte->Nature_Acte','$acte->Demandeur','$acte->Defendeur','$acte->Commune','$acte->CodCom' ,'$acte->Kilometre')";
                              	$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());
                                	if(!$req )
                                	{
                                        	$messRetour = 'ko';
                                	}
                               		 mysql_free_result($req);
				}
						
                        }
                        else
                                $messRetour = "ERREUR:CONNEXION TABLE IMPOSSIBLE";
                        mysql_close();
                }
                return $messRetour;
        }

}
?>
