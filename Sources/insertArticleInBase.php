<?php
	session_start();
	include('functions/bdd.php');
	include('functions/articles.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/apiComm.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut ajouter du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			if(isset($_POST['titreArticle']) 
				&& isset($_POST['tag']) 
				&& isset($_POST['contenu']) 
				&& isset($_POST['categorie']) 
				&& $_POST['titreArticle']!=""
				&& $_POST['categorie']!=""
				&& $_POST['contenu']!=""){
				
				$article=new Article();
				
				$article->setDate(date("Y-m-d H:i:s"));
				$article->setContenu($_POST['contenu']);
				$article->setTitre($_POST['titreArticle']);
				$article->setTags($_POST['tag']);
				$article->setIdCategorie($_POST['categorie']);
				$rep=$article->add();
				
				if($rep=="6" && isset($_POST['tweet']) && $_POST['tweet']=="tweet"){
					include('functions/InstallInfo.php');
					$rep2=tweet("Nouvel article sur ".$siteName." : ".$article->getTitre()." ".$localisationServeur."/visuArticle.php?art=".$article->getIdArticle());
					if(!$rep2){
						redirAccueil("38");	
					}
				}
				
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
