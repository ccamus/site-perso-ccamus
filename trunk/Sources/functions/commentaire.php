<?php


/*******************************************************************************************************************************************/
/*******************************************Définition de la classe Commentaire*************************************************************/
/*******************************************************************************************************************************************/
class Commentaire{
	private $idCommentaire;
	private $dateComm;
	private $commentateur;
	private $commentaire;
	private $idArticle;
	
	public function add(){
		
		if($this->commentaire==null || $this->commentaire==""){
			return "4";
		}		
		if($this->commentateur==null || $this->commentateur==""){
			return "31";
		}		
		if($this->idArticle==null || $this->idArticle=="" || !is_numeric($this->idArticle)){
			return "32";
		}
		
		$bdd=new BddConnector();
		$requeteVerif="select idArticle from article where idArticle=:idArticle";
		try{
			$rep="33";
		
			$stmtVerif = $bdd->getConnexion()->prepare($requeteVerif);
			$stmtVerif->bindValue(':idArticle', $this->idArticle, PDO::PARAM_STR);
			$stmtVerif->execute();
			
			if(!($row=$stmtVerif->fetch())){
				$rep="32";
				if(is_object($stmtVerif)){$stmtVerif->closeCursor();}
			}else{
				if(is_object($stmtVerif)){$stmtVerif->closeCursor();}
				$requete="INSERT INTO commentaire (dateComm, commentateur, commentaire, idArticle)
					VALUES (:dateComm, :commentateur, :commentaire, :idArticle);";
			
				$stmt = $bdd->getConnexion()->prepare($requete);
				$stmt->bindValue(':dateComm', $this->dateComm, PDO::PARAM_STR);
				$stmt->bindValue(':commentateur', $this->commentateur, PDO::PARAM_STR);
				$stmt->bindValue(':commentaire', $this->commentaire, PDO::PARAM_STR);
				$stmt->bindValue(':idArticle', $this->idArticle, PDO::PARAM_STR);
				$stmt->execute(); 	
				if(is_object($stmt)){$stmt->closeCursor();}
				
				$requete2="select idCommentaire from commentaire
					WHERE dateComm=:dateComm
						and commentateur=:commentateur
						and commentaire=:commentaire
						and idArticle=:idArticle;";
			
				$stmt2 = $bdd->getConnexion()->prepare($requete2);
				$stmt2->bindValue(':dateComm', $this->dateComm, PDO::PARAM_STR);
				$stmt2->bindValue(':commentateur', $this->commentateur, PDO::PARAM_STR);
				$stmt2->bindValue(':commentaire', $this->commentaire, PDO::PARAM_STR);
				$stmt2->bindValue(':idArticle', $this->idArticle, PDO::PARAM_STR);
				$stmt2->execute(); 
				
				if(!($row=$stmt2->fetch())){
					$rep="26";
				}else{
					$this->idCommentaire=$row['idCommentaire'];
				}
				if(is_object($stmt2)){$stmt2->closeCursor();}
			}
		}
		catch(PDOException $e){
			$bdd->deconnexion();
			return "26";
		}
		
		return $rep;
	}
	
	public function delete(){
		$rep="1";
		
		$bdd=new BddConnector();
		try{	
			$requete="DELETE FROM commentaire WHERE idCommentaire=:idCommentaire;";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':idCommentaire', $this->idCommentaire, PDO::PARAM_STR);
			$stmt->execute();
			if(is_object($stmt)){$stmt->closeCursor();}			
		}
		catch(PDOException $e){
			$bdd->deconnexion();
			$rep="26";
		}
		$bdd->deconnexion();		
		
		return $rep;
	}
	
	public function getIdCommentaire(){
		return $this->idCommentaire;
	}
	
	public function setIdCommentaire($idCommentaire){
		$this->idCommentaire=$idCommentaire;
	}
	
	public function getDateComm(){
		return $this->dateComm;
	}
	
	public function setDateComm($dateComm){
		$this->dateComm=$dateComm;
	}
	
	public function getCommentateur(){
		return $this->commentateur;
	}
	
	public function setCommentateur($commentateur){
		$this->commentateur=$commentateur;
	}
	
	public function getCommentaire(){
		return $this->commentaire;
	}
	
	public function setCommentaire($commentaire){
		$this->commentaire=str_replace("\n",'<br/>',$commentaire);
	}	
	
	public function getIdArticle(){
		return $this->idArticle;
	}
	
	public function setIdArticle($idArticle){
		$this->idArticle=$idArticle;
	}
}

function getCommentaireByArticleId($idArticle){
	
	if($idArticle==null || $idArticle=="" || !is_numeric($idArticle)){
		return "32";
	}
	
	$rep="";
	$arrayRetour = array();
	
	$bdd=new BddConnector();
	$requeteVerif="select idArticle from article where idArticle=:idArticle";
	try{	
		$stmtVerif = $bdd->getConnexion()->prepare($requeteVerif);
		$stmtVerif->bindValue(':idArticle', $idArticle, PDO::PARAM_STR);
		$stmtVerif->execute();
		
		if(!($row=$stmtVerif->fetch())){
			$rep="32";
			if(is_object($stmtVerif)){$stmtVerif->closeCursor();}
		}else{
			if(is_object($stmtVerif)){$stmtVerif->closeCursor();}
			$requete="select idCommentaire, dateComm, commentateur, commentaire
					from commentaire 
					where idArticle=:idArticle";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':idArticle', $idArticle, PDO::PARAM_STR);
			$stmt->execute();
			
			while($row=$stmt->fetch()){
				$commentaire=new Commentaire();
				$commentaire->setIdCommentaire($row['idCommentaire']);
				$commentaire->setCommentaire($row['commentaire']);
				$commentaire->setCommentateur($row['commentateur']);
				$commentaire->setDateComm($row['dateComm']);
				$arrayRetour[]=$commentaire;
			}
			if(is_object($stmt)){$stmt->closeCursor();}
		}
	}
	catch(PDOException $e){
		$bdd->deconnexion();
		$rep="26";
	}
	$bdd->deconnexion();
	
	if($rep==""){
		$rep=$arrayRetour;
	}
	
	return $rep;
}

function countCommentaireByArticle($idArticle){
	
	if($idArticle==null || $idArticle=="" || !is_numeric($idArticle)){
		return "";
	}
	
	$rep="";
	
	$bdd=new BddConnector();
	$requeteVerif="select idArticle from article where idArticle=:idArticle";
	try{	
		$stmtVerif = $bdd->getConnexion()->prepare($requeteVerif);
		$stmtVerif->bindValue(':idArticle', $idArticle, PDO::PARAM_STR);
		$stmtVerif->execute();
		
		if(!($row=$stmtVerif->fetch())){
			$rep="";
			if(is_object($stmtVerif)){$stmtVerif->closeCursor();}
		}else{
			if(is_object($stmtVerif)){$stmtVerif->closeCursor();}
			$requete="select count(idCommentaire) as c
					from commentaire 
					where idArticle=:idArticle";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':idArticle', $idArticle, PDO::PARAM_STR);
			$stmt->execute();
			
			if($row=$stmt->fetch()){
				$rep=$row['c'];
			}
			if(is_object($stmt)){$stmt->closeCursor();}
		}
	}
	catch(PDOException $e){
		$bdd->deconnexion();
		$rep="";
	}
	$bdd->deconnexion();
		
	return $rep;
}

?>
