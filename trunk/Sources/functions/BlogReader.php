<?php



class BlogReader{
	
	private $lastDate;
	private $firstDate;
	private $mode;
	private $data;
	
	public function __construct($firstDate="", $lastDate="", $mode, $data){
		//ici on reçoit la date au format 20121103131143
		if($lastDate!=""){
			$this->lastDate=$this->dateToReadable($lastDate);
		}
		if($firstDate!=""){
			$this->firstDate=$this->dateToReadable($firstDate);
		}
		$this->mode=$mode;
		if(isset($_GET['mod']) 
			&& $_GET['mod'] == "search"){
			// Si on est en mode recherche, on formate data.
			$this->data= str_replace(" ", "%", trim(rawurldecode($data)));
			$this->data = "%".$this->data."%";
		}else{
			$this->data=$data;
		}
	}
	
	public function getEight($next){
		include("InstallInfo.php");
		
		$inserRequete = $this->getInserRequeteMode();
				
		$bdd=new BddConnector();
		$arrayRetour = array();
		if(($next && $this->lastDate=="") || (!$next && $this->firstDate=="")){
			//erreur les données ne concordent pas, on affiche fonc le truc par défaut
			$this->lastDate="";
			$this->firstDate="";
		}
		
		if($this->lastDate=="" && $this->firstDate==""){//Premier appel
			$requete="select idArticle, titre, tags, dateArticle, contenu, idCategorie
			from article";
			if(isset($inserRequete)){
				$requete.=" WHERE ".$inserRequete;
			}
			$requete.=" order by dateArticle desc
			limit ".$nbArticlesParPage." ;";
		}else{
			if($next){//on va vers les plus vieux
				$requete="select idArticle, titre, tags, dateArticle, contenu, idCategorie
				from article
				where dateArticle < :Date ";
				if(isset($inserRequete)){
					$requete.=" AND ".$inserRequete;
				}
				$requete.=" order by dateArticle desc
				limit ".$nbArticlesParPage." ;";
			}else{//on va vers les plus récents
				$requete="select idArticle, titre, tags, dateArticle, contenu, idCategorie
				from (select idArticle, titre, tags, dateArticle, contenu, idCategorie
					from article
					where dateArticle > :Date ";
				if(isset($inserRequete)){
					$requete.=" AND ".$inserRequete;
				}
				$requete.=" order by dateArticle asc limit ".$nbArticlesParPage.") as t
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
			if(isset($inserRequete)){
				$stmt->bindValue(':data', $this->data, PDO::PARAM_STR);
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
				$article->setIdCategorie($row['idCategorie']);
				$arrayRetour[]=$article;
				
				$i++;
			}
			if(is_object($stmt)){$stmt->closeCursor();}
			$bdd->deconnexion();		
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		return $arrayRetour;
	}
	
	public function asNext(){
		$retour=false;
		
		$inserRequete = $this->getInserRequeteMode();
		
		$bdd=new BddConnector();
		$requete="select idArticle
			from article
			where dateArticle < :Date ";
		if(isset($inserRequete)){
			$requete.="AND ".$inserRequete;
		}
		$requete.=" ;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':Date', $this->lastDate, PDO::PARAM_STR);
			if(isset($inserRequete)){
				$stmt->bindValue(':data', $this->data, PDO::PARAM_STR);
			}
			$stmt->execute();
			if($row=$stmt->fetch()){
				$retour=true;
			}
			if(is_object($stmt)){$stmt->closeCursor();}
			$bdd->deconnexion();		
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
	
		return $retour;
	}
	
	public function asPreview(){
		$retour=false;
		
		$inserRequete = $this->getInserRequeteMode();
		
		$bdd=new BddConnector();
		$requete="select idArticle
			from article
			where dateArticle > :Date ";
		if(isset($inserRequete)){
			$requete.="AND ".$inserRequete;
		}
		$requete.=" ;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':Date', $this->firstDate, PDO::PARAM_STR);
			if(isset($inserRequete)){
				$stmt->bindValue(':data', $this->data, PDO::PARAM_STR);
			}
			$stmt->execute();
			if($row=$stmt->fetch()){
				$retour=true;
			}
			if(is_object($stmt)){$stmt->closeCursor();}
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
	
	private function getInserRequeteMode(){
		$inserRequete = null;
		if(isset($this->mode)){
			// On a un mode actif
			if($this->mode=="date"){
				// On recherche par date
				if(isset($this->data) && strlen($this->data)==6){
					$inserRequete = "strftime ( '%m%Y' , dateArticle ) = :data";
				}
			}else if ($this->mode=="categ"){
				// On recherche par catégorie
				if(isset($this->data) && strlen($this->data)>=1){
					$inserRequete = "idCategorie = :data";
				}			
			}else if($this->mode=="search"){
				// On recherche par mot clé
				if(isset($this->data) && strlen($this->data)>=1){
					$inserRequete = " ( titre LIKE :data OR :tags LIKE :data OR contenu LIKE :data ) ";
				}
			}
		}
		return $inserRequete;
	}
	
}

?>
