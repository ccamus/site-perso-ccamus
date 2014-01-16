<?php

	session_start();
	
	include('functions/bdd.php');
	include('functions/other.php');
	include('functions/fichier.php');
	include('functions/gereUsers.php');
	include('functions/functionsCV.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		//il est connecté?
		if(isset($_GET['action']) 
			&& ($_GET['action'] == "pdf" 
				|| $_GET['action'] == "chLong" 
				|| $_GET['action'] == "chCourt" 
				|| $_GET['action'] == "chEng")){
			// On a nos infos
			if($_GET['action'] == "pdf" ){
				// En mode PDF
				if(!isset($_FILES['fichier'])){
					redirAccueil("10");		
				}
				$erreur="";
				if ($_FILES['fichier']['error'] > 0) $erreur = "21";
				if ($_FILES['fichier']['size'] > 104857600) $erreur = "22";
						
				if($erreur!=""){
					redirAccueil($erreur);
				}else{
					$fileName = "CV/CV.pdf";
					if(fileAlreadyExist($fileName)){
						unlink($fileName);
					}
					$resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],$fileName);
					
					if ($resultat) {
						// Tout va  bien
						redirAccueil("43");
					}else{
						// Erreur
						redirAccueil("44");
					}
				}
			}else{
				// Ici on modifie forcément du contenu
				if(isset($_POST['contenu']) && $_POST['contenu'] != ""){
					if($_GET['action'] == "chLong" ){
						// Modification du CV long
						$retour = writeContenuCV("1", $_POST['contenu']);
					}else if($_GET['action'] == "chCourt" ){
						// Modification du CV court
						$retour = writeContenuCV("2", $_POST['contenu']);
					}else{
						// Modification du CV anglais
						$retour = writeContenuCV("3", $_POST['contenu']);						
					}
				}else{
					redirAccueil("10");		
				}
				if($retour){
					// Tout va  bien
					redirAccueil("46");
				}else{
					// Erreur
					redirAccueil("45");
				}
			}
		}else{
			redirAccueil("10");		
		}
	}else{
		redirAccueil("9");
	}

?>