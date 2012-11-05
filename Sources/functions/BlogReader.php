<?php

class BlogReader{
	
	private $lastDate;
	private $firstDate;
	
	public function __construct($firstDate="", $lastDate=""){
		//ici on reçoit la date au format 20121103131143
		if($lastDate!=""){
			$this->lastDate=$this->dateToReadable($lastDate);
		}
		if($firstDate!=""){
			$this->firstDate=$this->dateToReadable($firstDate);
		}
	}
	
	public function getEight($next){
		$bdd=new BddConnector();
		$arrayRetour = array();
		if(($next && $this->lastDate=="") || (!$next && $this->firstDate=="")){
			//erreur les données ne concordent pas, on affiche fonc le truc par défaut
			$this->lastDate="";
			$this->firstDate="";
		}
		
		if($this->lastDate=="" && $this->firstDate==""){//Premier appel
			$requete="select idArticle, titre, tags, dateArticle, contenu
			from article, contenuPage
			where article.idContenu=contenuPage.idContenu
			order by dateArticle desc
			limit 8 ;";
		}else{
			if($next){//on va vers les plus vieux
				$requete="select idArticle, titre, tags, dateArticle, contenu
				from article, contenuPage
				where article.idContenu=contenuPage.idContenu
					and dateArticle < :Date 
				order by dateArticle desc
				limit 8 ;";
			}else{//on va vers les plus récents
				$requete="select idArticle, titre, tags, dateArticle, contenu
				from (select idArticle, titre, tags, dateArticle, contenu
					from article, contenuPage
					where article.idContenu=contenuPage.idContenu
						and dateArticle > :Date 
					order by dateArticle asc limit 8) as t
				order by dateArticle desc ;";
			}
		}
		
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			if($this->lastDate!="" || $this->firstDate!=""){
				if($next){
					$stmt->bindValue(':Date', $this->lastDate, PDO::PARAM_STR);
				}else{
					$stmt->bindValue(':Date', $this->firstDate, PDO::PARAM_STR);
				}
			}
			$stmt->execute();
			$i=1;
			
			while($row=$stmt->fetch()){				
				if($i==1){
					$this->firstDate=$row['dateArticle'];
				}
				$this->lastDate=$row['dateArticle'];
				$article=new article();
				$article->setContenu($row['contenu']);
				$article->setDate($row['dateArticle']);
				$article->setIdArticle($row['idArticle']);
				$article->setTags($row['tags']);
				$article->setTitre($row['titre']);
				$arrayRetour[]=$article;
				
				$i++;
			}
			
			$bdd->deconnexion();		
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		return $arrayRetour;
	}
	
	public function asNext(){
		$retour=false;
		
		$bdd=new BddConnector();
		$requete="select idArticle
			from article
			where dateArticle < :Date ;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':Date', $this->lastDate, PDO::PARAM_STR);
			$stmt->execute();
			if($row=$stmt->fetch()){
				$retour=true;
			}
			$bdd->deconnexion();		
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
	
		return $retour;
	}
	
	public function asPreview(){
		$retour=false;
		
		$bdd=new BddConnector();
		$requete="select idArticle
			from article
			where dateArticle > :Date ;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':Date', $this->firstDate, PDO::PARAM_STR);
			$stmt->execute();
			if($row=$stmt->fetch()){
				$retour=true;
			}
			$bdd->deconnexion();		
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
	
		return $retour;
	}
	
	public function getLastDate(){
		//ici on veut envoyer la date au format 20121103131143
		return $this->dateToUnreadable($this->lastDate);
	}
	
	public function getFirstDate(){
		//ici on veut envoyer la date au format 20121103131143
		return $this->dateToUnreadable($this->firstDate);
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
