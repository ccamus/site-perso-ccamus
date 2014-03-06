<?php

	/**
	* Récupère le flux rss des articles.
	*/
	function genereArticleRSS(){
		include('InstallInfo.php');
		
		try{
			$bdd=new BddConnector();
			$arrayArticles = array();
			$requete="select idArticle, titre, dateArticle, contenu, labelCategorie
				FROM article, categorie 
				WHERE article.idCategorie = categorie.idCategorie 
				order by dateArticle desc";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->execute();
			
			$items = "";
			
			while($row=$stmt->fetch()){
				$items .= '<item>';
				$items .= '<title>'.$row['titre'].'</title>';
				$items .= '<category>'.$row['labelCategorie'].'</category>';
				$items .= '<link>'.$localisationServeur.'/visuArticle.php?art='.$row['idArticle'].'</link>';
				$items .= '<pubDate>'.$row['dateArticle'].'</pubDate>'; 
				$items .= '<description>'.str_replace('<br/>',"\n",substr($row['contenu'],0,700)).'</description>';
				$items .= '</item>';
			}
			
			$enTete = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$channel ='<rss version="2.0"><channel><title>'.$siteName.' articles</title><link>'.$localisationServeur.'</link><description>Liste des articles pour le site '.$siteName.'</description>';
			$closing = '</channel></rss>';
			
			$bdd->deconnexion();
			// écriture dans le fichier
			$fp = fopen("RSS/articlesFeed.xml", 'w');
			fputs($fp, $enTete.$channel.$items.$closing);
			fclose($fp);
			
			return true;
		}catch(Exception $e){
			return false;
		}
	}
	
	/**
	* Récupère le flux rss des commentaires.
	*/
	function genereCommentaireRSS(){
		include('InstallInfo.php');
		
		try{
			$bdd=new BddConnector();
			$arrayArticles = array();
			$requete="select dateComm, commentateur, commentaire, article.idArticle, titre
				FROM article, commentaire 
				WHERE article.idArticle = commentaire.idArticle 
				order by dateComm desc";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->execute();
			
			$items = "";
			
			while($row=$stmt->fetch()){
				$items .= '<item>';
				$items .= '<title>Commentaire sur l\'article '.$row['titre'].'</title>';
				$items .= '<link>'.$localisationServeur.'/visuArticle.php?art='.$row['idArticle'].'#com</link>';
				$items .= '<pubDate>'.$row['dateComm'].'</pubDate>'; 
				$items .= '<description>'.$row['commentateur'].' a posté le commentaire : '.str_replace('<br/>',"\n",substr($row['commentaire'],0,700)).'</description>';
				$items .= '</item>';
			}
			
			$enTete = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
			$channel ='<rss version="2.0"><channel><title>'.$siteName.' commentaires</title><link>'.$localisationServeur.'</link><description>Liste des commentaires pour le site '.$siteName.'</description>';
			$closing = '</channel></rss>';
			
			$bdd->deconnexion();
			// écriture dans le fichier
			$fp = fopen("RSS/commentairesFeed.xml", 'w');
			fputs($fp, $enTete.$channel.$items.$closing);
			fclose($fp);
			
			return true;
		}catch(Exception $e){echo $e;
			return false;
		}
	}
?>