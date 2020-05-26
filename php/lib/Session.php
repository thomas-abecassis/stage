<?php
class Session {
    public static function is_user($login) {
        return (!empty($_SESSION['login']) && ($_SESSION['login'] == $login));
    }

    public static function is_super_admin() {
    	return (!empty($_SESSION['role']) && $_SESSION['role']==3);
	}

    public static function is_admin() {
    	return (!empty($_SESSION['role']) && ($_SESSION['role']==2 || $_SESSION['role']==3));
	}

	public static function is_commercial() {
    	return (!empty($_SESSION['role']) && $_SESSION['role']=1);
	}
}
?>