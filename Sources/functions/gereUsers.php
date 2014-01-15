<?php


/*******************************************************************************************************************************************/
/*******************************************utilisateur existant ?**************************************************************************/
/*******************************************************************************************************************************************/
	function isExist($login, $cryptedMDp){
		$retour=false;
		
		$bdd=new BddConnector();
		//Récupération de l'id contenu
		$requete="SELECT nom,mdp FROM users WHERE nom=:nom AND mdp=:mdp;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':nom', $login, PDO::PARAM_STR);
			$stmt->bindValue(':mdp', $cryptedMDp, PDO::PARAM_STR);
			$stmt->execute(); 	
			$row=$stmt->fetch();	
			if(is_object($stmt)){$stmt->closeCursor();}
			if(isset($row['nom'])){
				$retour=true;
			}			
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		$bdd->deconnexion();
		
		return $retour;
	}
	
	function userExist($userName){
		$retour=false;
		
		$bdd=new BddConnector();
		//Récupération de l'id contenu
		$requete="SELECT nom FROM users WHERE nom=:nom;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':nom', $userName, PDO::PARAM_STR);
			$stmt->execute();
			
			if($row=$stmt->fetch()){
				$retour=true;
			}
			if(is_object($stmt)){$stmt->closeCursor();}			
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		$bdd->deconnexion();
		
		return $retour;
	}
	
?>
