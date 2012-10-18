<?php

/*******************************************************************************************************************************************/
/********************Tests de la classe article*********************************************************************************************/
/*******************************************************************************************************************************************/

	
	echo "<h1>Test de la classe Article</h1><br/>";
	
	echo "1 - include des fonctions<br/>";
	include('../Sources/functions.php');
	
	echo "2 - création de l'objet article<br/>";
	$article=new Article();
	$article->setDate("12/12/2012");
	$article->setContenu("contenu");
	$article->setTitre("Titre");
	$article->setTags("tags");
	//$article->setCommentaires($date);
	
	echo "3 - insertion en base de l'article<br/>";
	$article->add();

?>
