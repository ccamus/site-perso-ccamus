<?php

	session_start();
	
	include('functions/bdd.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/articles.php');
	include('functions/rss.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			if(isset($_POST['articles'])){
				$article=new Article();
				$article->setIdArticle($_POST['articles']);
				
				$rep=$article->delete();
				
				// Génération du rss
				if($rep=="1"){
					if(!genereArticleRSS()){
						$rep = "47";
					}
				}
				
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
