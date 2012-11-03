<?php

class BlogReader{
	
	private $lastDate;
	private $asNext;
	private $asPreview;
	
	public function __construct($lastDate=""){
		//ici on reçoit la date au format 20121103131143
		if($lastDate==""){
			$this->lastDate="";
		}else{
			$this->lastDate=$this->dateToReadable($lastDate);
		}
		$this->asNext=false;
		$this->asPreview=false;
	}
	
	public function getEight($next){
		$this->asNext=false;
		$bdd=new BddConnector();
		$arrayRetour = array();
		$symboleDeRecherche="<";
		if(!$next){
			$symboleDeRecherche=">";
			$this->asNext=true;
		}
		
		if($this->lastDate==""){//Premier appel
			$requete="select idArticle, titre, tags, dateArticle, contenu from article, contenuPage where article.idContenu=contenuPage.idContenu order by dateArticle desc limit 9 ;";
		}else{
			if($next){//on va vers les plus vieux
				$this->asPreview=true;
				$requete="select idArticle, titre, tags, dateArticle, contenu from article, contenuPage where article.idContenu=contenuPage.idContenu and dateArticle ".$symboleDeRecherche." :lastDate order by dateArticle desc limit 9 ;";
			}else{//on va vers les plus récents
				$requete="select idArticle, titre, tags, dateArticle, contenu from (select idArticle, titre, tags, dateArticle, contenu from article, contenuPage where article.idContenu=contenuPage.idContenu and dateArticle ".$symboleDeRecherche." :lastDate order by dateArticle asc limit 9) as t order by dateArticle desc ;";
			}
		}
		
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			if($this->lastDate!=""){
				$stmt->bindValue(':lastDate', $this->lastDate, PDO::PARAM_STR);
			}
			$stmt->execute();
			$i=1;
			
			while($row=$stmt->fetch()){
				if($i==9){
					$this->asNext=true;
				}else{
					$this->lastDate=$row['dateArticle'];
					$article=new article();
					$article->setContenu($row['contenu']);
					$article->setDate($row['dateArticle']);
					$article->setIdArticle($row['idArticle']);
					$article->setTags($row['tags']);
					$article->setTitre($row['titre']);
					$arrayRetour[]=$article;
				}
				$i++;
			}
			
			$bdd->deconnexion();		
		}
		catch(PDOException $e){
			$bdd->deconnexion(); echo $e->getMessage();
		}
		
		return $arrayRetour;
	}
	
	public function asNext(){
		return $this->asNext;
	}
	
	public function asPreview(){
		return $this->asPreview;
	}
	
	public function getLastDate(){
		//ici on veut envoyer la date au format 20121103131143
		return $this->dateToUnreadable($this->lastDate);
	}
	
	private function dateToUnreadable($date){
		//on transforme de 2012-11-03 13:11:43 en 20121103131143
		$date=str_replace("-","",$date);
		$date=str_replace(" ","",$date);
		$date=str_replace(":","",$date);
		return $date;			
	}
	
	private function dateToReadable($date){
		//on transforme de 20121103131143 en 2012-11-03 13:11:43
		$sortie=substr($date,0,4)."-";
		$sortie.=substr($date,4,2)."-";
		$sortie.=substr($date,6,2)." ";
		$sortie.=substr($date,8,2).":";
		$sortie.=substr($date,10,2).":";
		$sortie.=substr($date,12,2);
		
		return $sortie;
	}
	
}

?>
