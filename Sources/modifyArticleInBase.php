<?php
	session_start();
	
	include('functions/bdd.php');
	include('functions/articles.php');
	include('functions/other.php');
	include('functions/contenus.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut changer du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			if(isset($_SESSION['articles']) && $_SESSION['articles']!="" && isset($_POST['contenu']) && $_POST['contenu']!=""){
				//On change!
				$article=new Article();
				$article->setIdArticle($_SESSION['articles']);
				$article->setContenu($_POST['contenu']);
				$article->setTitre($_POST['titreArticle']);
				$article->setTags($_POST['tag']);
				
				$rep=$article->modify();
				
				redirAccueil($rep);
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
