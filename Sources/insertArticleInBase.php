<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut ajouter du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			if(isset($_POST['titreArticle']) 
				&& isset($_POST['tag']) 
				&& isset($_POST['contenu']) 
				&& $_POST['titreArticle']!=""
				&& $_POST['contenu']!=""){
				
				$article=new Article();
				
				$article->setDate(date("Y-m-d H:m:s"));
				$article->setContenu($_POST['contenu']);
				$article->setTitre($_POST['titreArticle']);
				$article->setTags($_POST['tag']);
				$rep=$article->add();
				
				redirAccueil($rep);	
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
