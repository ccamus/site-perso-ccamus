<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		//il est connecté?
		$retour=deleteFiles($_POST);
		
		if($retour){
			redirAccueil("14");
		}else{
			redirAccueil("15");
		}
	}else{
		redirAccueil("9");	
	}
?>
