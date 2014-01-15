<?php

	session_start();
	
	include("functions/bdd.php");
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/commentaire.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			if(isset($_GET['com']) && isset($_GET['art'])){
				$commentaire=new Commentaire();
				$commentaire->setIdCommentaire($_GET['com']);
				
				$rep=$commentaire->delete();
				
				redirVisuArticle($_GET['art'],$rep);	
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
