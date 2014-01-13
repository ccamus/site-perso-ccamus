<?php

	session_start();
	include('functions/other.php');
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		session_destroy();
		$_SESSION = array();
		redirAccueil("11");
	}else{
		redirAccueil("12");
	}
?>
