<?php

/*******************************************************************************************************************************************/
/********************Tests de la classe article*********************************************************************************************/
/*******************************************************************************************************************************************/
	$rep=testArticle();
	if($rep=="1"){
		echo "<br/><h1>ERROR</h1>";
	}else{
		echo "<br/><h1>OK</h1>";
	}

	function testArticle(){
		echo "<h1>Test de la classe Article</h1><br/>";
		
		echo "1 - include des fonctions<br/>";
		include('../Sources/functions.php');
		include('../Sources/functions/messages.php');
		
		echo "2 - création de l'objet article<br/>";
		$article=new Article();
		$article2=new Article();
		$article->setDate("2012-12-27 00:00:00");
		$article->setContenu("contenu");
		$article->setTitre("Titre");
		$article->setTags("tags");
		
		echo "3 - insertion en base de l'article<br/>";
		$rep=$article->add();
		if($rep!=""){echo $msgs[$rep]."<br/>";}
		if($rep!=6){
			return 1;
		}
		
		echo "4 - Récupération de l'article<br/>";
		$rep=$article2->getArticleById($article->getIdArticle());
		if($rep!=""){echo $msgs[$rep]."<br/>";}
		if($rep!=""){
			return 1;
		}
		if($article->getDate()!=$article2->getDate()){
			echo '<b>la date est différente</b><br/>';
		}
		if($article->getContenu()!=$article2->getContenu()){
			echo '<b>le contenu est différent</b><br/>';
		}
		if($article->getTitre()!=$article2->getTitre()){
			echo '<b>le titre est différent</b><br/>';
		}
		if($article->getTags()!=$article2->getTags()){
			echo '<b>les tags sont différents</b><br/>';
		}
		/*if($article->getCommentaires()!=$article2->getCommentaires()){
			echo '<b>la date est différente</b><br/>';
		}*/
		
		echo "5 - Modification de l'article<br/>";
		$article->setTitre('titremodifié');
		$rep=$article->modify();
		if($rep!=""){echo $msgs[$rep]."<br/>";}
		if($rep!=8){
			return 1;
		}
		
		echo "6 - Affichage de la liste de sélection<br/>";
		echo listArticlesForModify()."<br/>";
		
		echo "7 - Récupération de l'article<br/>";
		$rep=$article2->getArticleById($article->getIdArticle());
		if($rep!=""){echo $msgs[$rep]."<br/>";}
		if($rep!=""){
			return 1;
		}
		if('titremodifié'!=$article2->getTitre()){
			echo '<b>le titre est différent</b>'.$article2->getTitre().'<br/>';
		}
		
		echo "8 - Suppression de l'article<br/>";
		$rep=$article->delete();
		if($rep!=""){echo $msgs[$rep]."<br/>";}
		if($rep!="1"){
			return 1;
		}
		
		echo "9 - Récupération de l'article<br/>";
		$rep=$article2->getArticleById($article->getIdArticle());
		if($rep!=""){echo $msgs[$rep]."<br/>";}
		if($rep==""){
			return 1;
		}
		
		return 0;
	}
	

?>
