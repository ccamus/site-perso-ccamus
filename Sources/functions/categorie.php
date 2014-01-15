<?php

/*******************************************************************************************************************************************/
/*******************************************Définition de la classe categorie***************************************************************/
/*******************************************************************************************************************************************/
class Categorie{
	private $idCategorie;
	private $labelCategorie;
	
	public function __construct($idCategorie, $labelCategorie){
		$this->idCategorie=$idCategorie;
		$this->labelCategorie=$labelCategorie;
	}
	
	public function add(){
		//pas de contenu?
		if($this->labelCategorie==null || $this->labelCategorie==""){
			return "4";
		}
		
		$bdd=new BddConnector();
		try{
			//insertion dans la table categorie	
			$requete="INSERT INTO categorie (labelCategorie) VALUES ( :labelCategorie );";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':labelCategorie', $this->labelCategorie, PDO::PARAM_STR);
			$stmt->execute();
			if(is_object($stmt)){$stmt->closeCursor();}
			//récupération de l'id de la categorie
			$requete="SELECT idCategorie FROM categorie WHERE labelCategorie= :labelCategorie ;";
			
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':labelCategorie', $this->labelCategorie, PDO::PARAM_STR);
			$stmt->execute(); 		
			$row=$stmt->fetch();
			if(is_object($stmt)){$stmt->closeCursor();}
			$bdd->deconnexion();

			if(!isset($row['idCategorie'])){
				return "5";
			}else{
				$this->idCategorie=$row['idCategorie'];
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
			$requete1="DELETE FROM article WHERE idCategorie=:idCategorie;";
			$requete2="DELETE FROM categorie WHERE idCategorie=:idCategorie;";
			
			$stmt1 = $bdd->getConnexion()->prepare($requete1);
			$stmt2 = $bdd->getConnexion()->prepare($requete2);
			
			$stmt1->bindValue(':idCategorie', $this->idCategorie, PDO::PARAM_STR);
			$stmt2->bindValue(':idCategorie', $this->idCategorie, PDO::PARAM_STR);
			
			$stmt1->execute(); 	
			if(is_object($stmt1)){$stmt1->closeCursor();}
			$stmt2->execute(); 	
			if(is_object($stmt2)){$stmt2->closeCursor();}
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
		if($this->labelCategorie==null || $this->labelCategorie==""){
			$rep="4";
		}else{
			
			$bdd=new BddConnector();
			try{
				//insertion dans la table du nouveau contenu
				$requete2="UPDATE categorie SET labelCategorie= :labelCategorie WHERE idCategorie= :idCategorie ;";
				$stmt2 = $bdd->getConnexion()->prepare($requete2);
				$stmt2->bindValue(':labelCategorie', $this->labelCategorie, PDO::PARAM_STR);
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

	public function getIdCategorie(){
		return $this->idCategorie;
	}

	public function getLabelCategorie(){
		return $this->labelCategorie;
	}

	public function setIdCategorie($idCategorie){
		$this->idCategorie=$idCategorie;
	}

	public function setLabelCategorie($labelCategorie){
		$this->labelCategorie=$labelCategorie;
	}

}

function getAllCategories(){
	$retour = null;
	$bdd=new BddConnector();
	$requete="SELECT labelCategorie, idCategorie FROM categorie ORDER BY labelCategorie ;";
	
	try{
		$stmt = $bdd->getConnexion()->prepare($requete);
		$stmt->execute(); 
		
		while($row=$stmt->fetch()){
			$retour[] = new Categorie($row['idCategorie'], $row['labelCategorie']);
		}
	
	}catch(PDOException $e){
		$bdd->deconnexion();
		$rep="5";
	}
	return $retour;
}

function getCategorieByIdCategorie($idCategorie){
	$retour = null;
	$bdd=new BddConnector();
	$requete="SELECT labelCategorie, idCategorie FROM categorie WHERE idCategorie = :idCategorie ;";
	
	try{
		$stmt = $bdd->getConnexion()->prepare($requete);
		$stmt->bindValue(':idCategorie', $idCategorie, PDO::PARAM_STR);
		$stmt->execute(); 
		
		$row=$stmt->fetch();
		if(is_object($stmt)){$stmt->closeCursor();}
		if(isset($row['idCategorie'])){
			$retour = new Categorie($row['idCategorie'], $row['labelCategorie']);
		}
			
	}catch(PDOException $e){
		$bdd->deconnexion();
		$rep="5";
	}
	return $retour;
}

?>
