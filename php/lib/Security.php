<?php
class Security {
	private static $seed="xT1lVluyBi";

	public static function chiffrer($texte_en_clair) {
		$texte_en_claire=Security::$seed.$texte_en_clair;
		$texte_chiffre = hash('sha256', $texte_en_clair);
		return $texte_chiffre;
	}

	public static function generateRandomHex() {
	// cette fonction servait à la validation des e-mail
	  $numbytes = 16; 
	  $bytes = openssl_random_pseudo_bytes($numbytes); 
	  $hex   = bin2hex($bytes);
	  return $hex;
	}
}