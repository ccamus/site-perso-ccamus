<?php

/*******************************************************************************************************************************************/
/********************Tests de la classe BddConnector****************************************************************************************/
/*******************************************************************************************************************************************/
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
	error_reporting(E_ALL);


	$rep=testBDD();
	if($rep==1){
		echo "<br/><h1>ERROR</h1>";
	}else{
		echo "<br/><h1>OK</h1>";
	}

	function testBDD(){
		echo "<h1>Test de la classe BddConnector</h1><br/>";
		
		echo "1 - include des fonctions<br/>";
		include('../Sources/functions.php');
		
		echo "2 - cr�ation de l'objet BddConnector<br/>";
		$bdd=new BddConnector();
			
		$requete="SELECT contenu FROM contenuPage;";
		
		try{
			echo "3 - Premier appel de GetConnection<br/>";
			$bdd->getConnexion();
			
			$stmt = $bdd->getConnexion()->prepare($requete);
			echo "4 - Execution de la requ�te<br/>";
			$stmt->execute(); 
			$row=$stmt->fetch();
			$bdd->deconnexion();
			
			if(!isset($row['contenu'])){
				echo "Aucun retour<br/>";
			}else{
				echo "taille retour : ".strlen($row['contenu'])."<br/>";
			}			
		}
		catch(PDOException $e){
			$bdd->deconnexion();
			echo "Erreur PDO<br/>";
			return 1;
		}
		
		
		return 0;
	}
	

?>
