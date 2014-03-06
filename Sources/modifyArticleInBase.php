<?php
	session_start();
	
	include('functions/bdd.php');
	include('functions/articles.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/rss.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut changer du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			if(isset($_SESSION['articles']) && $_SESSION['articles']!="" 
				&& isset($_POST['contenu']) && $_POST['contenu']!=""
				&& isset($_POST['categorie']) && $_POST['categorie']!=""){
				//On change!
				$article=new Article();
				$article->setIdArticle($_SESSION['articles']);
				$article->setContenu($_POST['contenu']);
				$article->setTitre($_POST['titreArticle']);
				$article->setTags($_POST['tag']);
				$article->setIdCategorie($_POST['categorie']);
				
				$rep=$article->modify();
				
				// Génération du rss
				if($rep=="8"){
					if(!genereArticleRSS()){
						$rep = "47";
					}
				}
				
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
