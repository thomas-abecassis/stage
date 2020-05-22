<?php 
if(Session::is_admin()){
	move_uploaded_file( $_FILES['inputPhoto']['tmp_name'],"../../image/logo.png");
}

?>