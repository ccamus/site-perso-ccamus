<?php


/*******************************************************************************************************************************************/
/*******************************************Définition de la classe Article*****************************************************************/
/*******************************************************************************************************************************************/
class Article{
	private $idArticle;
	private $date;
	private $contenu;
	private $titre;
	private $tags;
	private $idCategorie;
	
	//Récupère un article selon son id
	public function getArticleById($id){
		
		$rep="";
		if(!is_numeric($id)){
			$rep="24";
		}else{
			$bdd=new BddConnector();
			
			$requete="SELECT dateArticle, contenu, titre, tags, idCategorie FROM  article WHERE idArticle=:idArt ;";
			
			try{
				$stmt = $bdd->getConnexion()->prepare($requete);
				$stmt->bindValue(':idArt', $id, PDO::PARAM_STR);
				$stmt->execute(); 
				$row=$stmt->fetch();
				if(is_object($stmt)){$stmt->closeCursor();}
				$bdd->deconnexion();
				
				if(!isset($row['contenu'])){
					$rep="24";
				}else{
					$this->idArticle=$id;
					$this->date=$row['dateArticle'];
					$this->contenu=$row['contenu'];
					$this->titre=$row['titre'];
					$this->tags=$row['tags'];
					$this->idCategorie=$row['idCategorie'];
				}				
			}
			catch(PDOException $e){
				$bdd->deconnexion();
				$rep="26";				
			}
		}
		
		$bdd->deconnexion();
		
		return $rep;
	}
	
	//Enregistre un article en base
	public function add(){
					
		//pas de contenu?
		if($this->contenu==null || $this->contenu==""){
			return "4";
		}
		
		$bdd=new BddConnector();
		try{
			//insertion dans la table article	
			$requete="INSERT INTO article (dateArticle,titre,tags,contenu,idCategorie) VALUES ( :date, :titre, :tags, :contenu, :idCategorie );";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
			$stmt->bindValue(':titre', $this->titre, PDO::PARAM_STR);
			$stmt->bindValue(':tags', $this->tags, PDO::PARAM_STR);
			$stmt->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
			$stmt->bindValue(':idCategorie', $this->idCategorie, PDO::PARAM_STR);
			$stmt->execute();
			if(is_object($stmt)){$stmt->closeCursor();}
			//récupération de l'id du contenu	
			$requete="SELECT idArticle FROM article WHERE dateArticle= :date ;";
			
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
			$stmt->execute(); 		
			$row=$stmt->fetch();
			if(is_object($stmt)){$stmt->closeCursor();}
			$bdd->deconnexion();

			if(!isset($row['idArticle'])){
				return "5";
			}else{
				$this->idArticle=$row['idArticle'];
			}
		}
		catch(PDOException $e){echo $e;
			$bdd->deconnexion();
			return "26";
		}
		
		$bdd->deconnexion();
		return "6";
	}
	
	function delete(){
		$rep="1";
		
		$bdd=new BddConnector();
		try{
			//récupération de l'id du contenu		
			$requete2="DELETE FROM article WHERE idArticle=:idArticle;";
			$requete4="DELETE FROM commentaire WHERE idArticle=:idArticle;";
			
			$stmt2 = $bdd->getConnexion()->prepare($requete2);
			$stmt4 = $bdd->getConnexion()->prepare($requete4);
			
			$stmt2->bindValue(':idArticle', $this->idArticle, PDO::PARAM_STR);
			$stmt4->bindValue(':idArticle', $this->idArticle, PDO::PARAM_STR);
			
			$stmt2->execute(); 	
			if(is_object($stmt2)){$stmt2->closeCursor();}
			$stmt4->execute(); 	
			if(is_object($stmt4)){$stmt4->closeCursor();}
		}
		catch(PDOException $e){
			$bdd->deconnexion();
			$rep="26";
		}
		$bdd->deconnexion();
		
		
		return $rep;
	}
	
	function modify(){
		$rep="8";
		//pas de contenu?
		if($this->contenu==null || $this->contenu==""){
			$rep="4";
		}else{
			
			$bdd=new BddConnector();
			try{
				//insertion dans la table du nouveau contenu
				$requete2="UPDATE article SET titre=:titre, tags=:tags, contenu=:contenu, idCategorie=:idCategorie WHERE idArticle=:id ;";
				$stmt2 = $bdd->getConnexion()->prepare($requete2);
				$stmt2->bindValue(':titre', $this->titre, PDO::PARAM_STR);
				$stmt2->bindValue(':tags', $this->tags, PDO::PARAM_STR);
				$stmt2->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
				$stmt2->bindValue(':id', $this->idArticle, PDO::PARAM_STR);
				$stmt2->bindValue(':idCategorie', $this->idCategorie, PDO::PARAM_STR);
				$stmt2->execute();
				if(is_object($stmt2)){$stmt2->closeCursor();}
			}
			catch(PDOException $e){
				$bdd->deconnexion();
				$rep="5";
			}
			$bdd->deconnexion();
		}
		
		return $rep;
	}
	
	public function getIdArticle(){
		return $this->idArticle;
	}
	
	public function setIdArticle($idArticle){
		$this->idArticle=$idArticle;
	}
	
	public function getDate(){
		return $this->date;
	}
	
	public function setDate($date){
		$this->date=$date;
	}
	
	public function getContenu(){
		return stripslashes($this->contenu);
	}
	
	public function setContenu($contenu){
		$contenu=str_replace("\n",'<br/>',$contenu);
		$this->contenu=$contenu;
	}
	
	public function getTitre(){
		return $this->titre;
	}
	
	public function setTitre($titre){
		$this->titre=$titre;
	}
	
	public function getTags(){
		return $this->tags;
	}
	
	public function setTags($tags){
		$this->tags=$tags;
	}
	
	public function getCommentaires(){
		return getCommentaireByArticleId($this->idArticle);
	}
	
	public function getCountCommentaires(){
		return countCommentaireByArticle($this->idArticle);
	}
	
	public function addCommentaire($commentaire){
		$commentaire->add();;
	}
	
	public function getIdCategorie(){
		return $this->idCategorie;
	}
	
	public function setIdCategorie($idCategorie){
		$this->idCategorie=$idCategorie;
	}
}

function listArticlesForModify(){
	$bdd=new BddConnector();
	
	$sortie="<select multiple name='articles' class='form-control'>";
	
	$requete="SELECT idArticle, titre FROM article ;";
	
	try{
		$stmt = $bdd->getConnexion()->prepare($requete);
		$stmt->execute(); 
		
		while($row=$stmt->fetch()){
			$sortie=$sortie."<option value=".$row['idArticle'].">".$row['titre']."</option>";
		}		
		if(is_object($stmt)){$stmt->closeCursor();}
		$bdd->deconnexion();		
	}
	catch(PDOException $e){
		$bdd->deconnexion();				
	}
	
	$sortie=$sortie."</select>";
	
	return $sortie;
}

function getMoisArticles(){
	$bdd=new BddConnector();
	$retour = null;
		
	$requete="SELECT DISTINCT strftime ( '%m-%Y' , dateArticle ) as m FROM article ORDER BY dateArticle DESC ;";
	
	try{
		$stmt = $bdd->getConnexion()->prepare($requete);
		$stmt->execute();
		
		while($row=$stmt->fetch()){
			$retour[] = $row['m'];
		}		
		if(is_object($stmt)){$stmt->closeCursor();}
		$bdd->deconnexion();		
	}
	catch(PDOException $e){
		$bdd->deconnexion();				
	}
		
	return $retour;
}

?>
