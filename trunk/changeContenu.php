<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut changer du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			if(isset($_SESSION['lien']) && $_SESSION['lien']!="" && isset($_POST['contenu']) && $_POST['contenu']!=""){
				//On change!
				$retour=changeContenu($_SESSION['lien'],$_POST['labelLien'],$_POST['tag'],$_POST['contenu']);
				redirAccueil($retour);
			}else{
				redirAccueil("10");
			}
		}else{
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");
	}
	
?>
