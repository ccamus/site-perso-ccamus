<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut changer du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			if(isset($_SESSION['lien']) && $_SESSION['lien']!="" && isset($_POST['contenu']) && $_POST['contenu']!=""){
				//On change!
				$rep=changeContenu($_SESSION['lien'],$_POST['labelLien'],$_POST['tag'],$_POST['contenu']);
				if($rep=="8"){
					$rep2=createMenuFile();
					redirAccueil($rep2);
				}else{
					redirAccueil($rep);	
				}
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
