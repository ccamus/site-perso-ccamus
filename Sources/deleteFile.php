<?php
	session_start();
	
	include('functions/bdd.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/fichier.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		//il est connecté?
		$retour=deleteFiles();
		
		if($retour){
			redirAccueil("14");
		}else{
			redirAccueil("15");
		}
	}else{
		redirAccueil("9");	
	}
?>
