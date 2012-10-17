<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut ajouter du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			if(isset($_POST['labelLien']) 
				&& isset($_POST['lienParent']) 
				&& isset($_POST['contenu']) 
				&& $_POST['labelLien']!=""
				&& $_POST['contenu']!=""){
				
				$rep=insertContenu($_POST['labelLien'],$_POST['lienParent'],$_POST['tag'],$_POST['contenu']);
				
				if($rep=="6"){
					if(createMenuFile()){
						redirAccueil("18");
					}else{
						redirAccueil("17");
					}
				}else{
					redirAccueil($rep);	
				}				
			}else{
				redirAccueil("16");
			}
		}else{
		redirAccueil("9");	
		}
	}else{
		redirAccueil("9");		
	}
?>
