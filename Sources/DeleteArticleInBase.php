<?php

	session_start();
	include("functions.php");
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			if(isset($_POST['articles'])){
				$article=new Article();
				$article->setIdArticle($_POST['articles']);
				
				$rep=$article->delete();
				
				redirAccueil($rep);	
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
