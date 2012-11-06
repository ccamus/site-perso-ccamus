<?php

/*******************************************************************************************************************************************/
/********************Tests de la classe commentaire*****************************************************************************************/
/*******************************************************************************************************************************************/
	$rep=testCommentaire();
	if($rep=="1"){
		echo "<br/><h1>ERROR</h1>";
	}else{
		echo "<br/><h1>OK</h1>";
	}

	function testCommentaire(){
		echo "<h1>Test de la classe Commentaire</h1><br/>";
		
		echo "1 - include des fonctions<br/>";
		include('../Sources/functions.php');
		include('../Sources/functions/messages.php');
		
		echo "2 - Création d'un article<br/>";
		$article=new Article();
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
		
		echo "4 - Création dun commentaire<br/>";
		$commentaire=new Commentaire();
		$commentaire->setDateComm("2012-12-28 00:00:00");
		$commentaire->setCommentateur("Charlie");
		$commentaire->setCommentaire("le texte");
		$commentaire->setIdArticle($article->getIdArticle());
		
		echo "5 - Ajout en base du commentaire<br/>";
		$rep=$commentaire->add();
		if($rep!="33"){echo $msgs[$rep]."<br/>";}
		if($rep!=33){
			return 1;
		}
		
		echo "6 - Visualisation du commentaire<br/>";
		$retour=getCommentaireByArticleId($article->getIdArticle());
		if(is_numeric($retour)){
			echo $msgs[$rep]."<br/>";
			return 1;
		}else{
			foreach($retour as $comm){
				if($comm->getDateComm() != $commentaire->getDateComm()){
					echo "DateComm est différent<br/>";
					return 1;
				}
				if($comm->getCommentateur() != $commentaire->getCommentateur()){
					echo "Commentateur est différent<br/>";
					return 1;
				}
				if($comm->getCommentaire() != $commentaire->getCommentaire()){
					echo "Commentaire est différent<br/>";
					return 1;
				}
			}
		}
		
		echo "7 - On compte le nombre de commentaires il y a<br/>";
		$rep=countCommentaireByArticle($article->getIdArticle());
		if($rep=="" || $rep!=1){
			return 1;
		}
		
		echo "8 - Suppression du commentaire<br/>";
		$rep=$commentaire->delete();
		echo $msgs[$rep]."<br/>";
		if($rep!=1){
			return 1;
		}
		
		echo "9 - On compte le nombre de commentaires il y a<br/>";
		$rep=countCommentaireByArticle($article->getIdArticle());
		if($rep=="" || $rep!=0){
			return 1;
		}
		
		echo "10 - Suppression de l'article<br/>";
		$rep=$article->delete();
		if($rep!=""){echo $msgs[$rep]."<br/>";}
		if($rep!="1"){
			return 1;
		}
		
		return 0;
	}
	

?>
