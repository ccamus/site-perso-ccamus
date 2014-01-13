<?php

	session_start();
	
	include('functions/bdd.php');
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/contenus.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			if(isset($_POST['liens'])){
				$rep=deleteContenu($_POST['liens']);
				if($rep=="1"){
					if(createMenuFile()){
						redirAccueil($rep);	
					}else{
						redirAccueil("17");	
					}
				}else{
					redirAccueil($rep);	
				}
			}else{
				redirAccueil("13");	
			}
		}else{
			redirAccueil("9");	
		}
	}else{
		redirAccueil("9");	
	}	
?>
