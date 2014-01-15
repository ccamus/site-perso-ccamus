<?php
	session_start();
	
	include('functions/bdd.php');
	include('functions/categorie.php');
	include('functions/gereUsers.php');
	include('functions/other.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		// Loggé
		if(isset($_GET['action']) && ( $_GET['action']== "add" || $_GET['action']== "md" )){
			// On a une action
			if($_GET['action']== "add"){
				// Mode ajout
				$categorie = new Categorie(0,$_POST['labelNewCateg']);
				
				$rep = $categorie->add();
			}else{
				$categories = getAllCategories();
				
				foreach($categories as $categorie){
					$haveToDelete = $_POST['suppressor_'.$categorie->getidCategorie()];
					if(isset($haveToDelete) && $haveToDelete == "supprimer"){
						// On supprime
						$rep = $categorie->delete();
						if($rep!="1"){
							// Erreur
							break;
						}
					}
					$newLabel = $_POST['labelCateg_'.$categorie->getidCategorie()];
					if($newLabel!=$categorie->getLabelCategorie()){
						// On modifie
						$categorie->setLabelCategorie($newLabel);
						$rep = $categorie->modify();
						if($rep!="8"){
							// Erreur
							break;
						}
					}
				}
			}
			redirAccueil($rep);
		}else{
			// On a pas d'action
			redirAccueil("10");
		}
	}else{
		redirAccueil("9");
	}


?>