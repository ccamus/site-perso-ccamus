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
	
	//Récupère un article selon son id
	public function getArticleById($id){
		
		$rep="";
		if(!is_numeric($id)){
			$rep="24";
		}else{
			$bdd=new BddConnector();
			
			$requete="SELECT dateArticle, contenu, titre, tags FROM contenuPage, article WHERE idArticle=:idArt AND contenuPage.idContenu=article.idContenu ;";
			
			try{
				$stmt = $bdd->getConnexion()->prepare($requete);
				$stmt->bindValue(':idArt', $id, PDO::PARAM_STR);
				$stmt->execute(); 
				$row=$stmt->fetch();
				$bdd->deconnexion();
				
				if(!isset($row['contenu'])){
					$rep="24";
				}else{
					$this->idArticle=$id;
					$this->date=$row['dateArticle'];
					$this->contenu=$row['contenu'];
					$this->titre=$row['titre'];
					$this->tags=$row['tags'];
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
				
		$contenu=str_replace("\n",'<br/>',$this->contenu);
					
		//pas de contenu?
		if($contenu==null || $contenu==""){
			return "4";
		}
		
		$bdd=new BddConnector();
		//insertion du contenu
		$requete="INSERT INTO contenuPage (contenu) VALUES (:contenu);";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':contenu', $contenu, PDO::PARAM_STR);
			$stmt->execute(); 				
				
			//récupération de l'id du contenu		
			$requete="SELECT idContenu FROM contenuPage WHERE contenu=:contenu;";
			
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':contenu', $contenu, PDO::PARAM_STR);
			$stmt->execute(); 		
			$row=$stmt->fetch();
			$bdd->deconnexion();

			if(!isset($row['idContenu'])){
				$bdd->deconnexion();
				return "5";
			}else{
				$id=$row['idContenu'];
			}
			
			//insertion dans la table article	
			$requete="INSERT INTO article (dateArticle,titre,tags,idContenu) VALUES (:date, :titre, :tags, :idContenu);";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
			$stmt->bindValue(':titre', $this->titre, PDO::PARAM_STR);
			$stmt->bindValue(':tags', $this->tags, PDO::PARAM_STR);
			$stmt->bindValue(':idContenu', $id, PDO::PARAM_STR);
			$stmt->execute();
			
			//récupération de l'id du contenu	
			$requete="SELECT idArticle FROM article WHERE idContenu=:id;";
			
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':id', $id, PDO::PARAM_STR);
			$stmt->execute(); 		
			$row=$stmt->fetch();
			$bdd->deconnexion();

			if(!isset($row['idArticle'])){
				return "5";
			}else{
				$this->idArticle=$row['idArticle'];
			}
		}
		catch(PDOException $e){
			$bdd->deconnexion();
			return "26";
		}
		
		$bdd->deconnexion();
		return "6";
	}
	
	function delete(){
		$rep="1";
		
		//Récupération de l'id contenu		
		$idContenu=$this->getIdContenuParIdArticle($this->idArticle);
		if($idContenu=="ERROR"){
			$rep="25";
		}else{
			$bdd=new BddConnector();
			try{
				//récupération de l'id du contenu		
				$requete2="DELETE FROM article WHERE idArticle=:idArticle;";
				$requete3="DELETE FROM contenuPage WHERE idContenu=:idContenu;";
				$requete4="DELETE FROM commentaire WHERE idArticle=:idArticle;";
				
				$stmt2 = $bdd->getConnexion()->prepare($requete2);
				$stmt3 = $bdd->getConnexion()->prepare($requete3);
				$stmt4 = $bdd->getConnexion()->prepare($requete4);
				
				$stmt2->bindValue(':idArticle', $this->idArticle, PDO::PARAM_STR);
				$stmt3->bindValue(':idContenu', $idContenu, PDO::PARAM_STR);
				$stmt4->bindValue(':idArticle', $this->idArticle, PDO::PARAM_STR);
				
				$stmt2->execute(); 	
				$stmt3->execute(); 	
				$stmt4->execute(); 	
								
			}
			catch(PDOException $e){
				$bdd->deconnexion();
				$rep="26";
			}
			$bdd->deconnexion();
		}
		
		return $rep;
	}
	
	function modify(){
		$rep="8";
		//pas de contenu?
		if($this->contenu==null || $this->contenu==""){
			$rep="4";
		}else{
			
			$bdd=new BddConnector();
		
			$contenu=str_replace("\n",'<br/>',$this->contenu);
			try{
				//insertion dans la table du nouveau contenu
				$requete="UPDATE contenuPage, article SET contenuPage.contenu=:contenu, article.titre=:titre, article.tags=:tags WHERE idArticle=:id AND contenuPage.idContenu=article.idContenu;";
				$stmt = $bdd->getConnexion()->prepare($requete);
				$stmt->bindValue(':contenu', $this->contenu, PDO::PARAM_STR);
				$stmt->bindValue(':titre', $this->titre, PDO::PARAM_STR);
				$stmt->bindValue(':tags', $this->tags, PDO::PARAM_STR);
				$stmt->bindValue(':id', $this->idArticle, PDO::PARAM_STR);
				$stmt->execute(); 	
			}
			catch(PDOException $e){
				$bdd->deconnexion();
				$rep="5";
			}
			$bdd->deconnexion();
		}
		
		return $rep;
	}
	
	private function getIdContenuParIdArticle($idArticle){
	
		$retour="ERROR";
	
		$bdd=new BddConnector();
		//Récupération de l'id contenu
		$requete="SELECT idContenu FROM article WHERE idArticle=:id;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':id', $idArticle, PDO::PARAM_STR);
			$stmt->execute(); 	
			$row=$stmt->fetch();	
			
			if(isset($row['idContenu'])){
				$retour=$row['idContenu'];
			}			
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		$bdd->deconnexion();
		return $retour;	
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
		return $this->contenu;
	}
	
	public function setContenu($contenu){
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
}

function listArticlesForModify(){
	$bdd=new BddConnector();
	
	$sortie="<select name='articles'>";
	
	$requete="SELECT idArticle, titre FROM article ;";
	
	try{
		$stmt = $bdd->getConnexion()->prepare($requete);
		$stmt->execute(); 
		
		while($row=$stmt->fetch()){
			$sortie=$sortie."<option value=".$row['idArticle'].">".$row['titre']."</option>";
		}		
		$bdd->deconnexion();		
	}
	catch(PDOException $e){
		$bdd->deconnexion();				
	}
	
	$sortie=$sortie."</select>";
	
	return $sortie;
}

?>
