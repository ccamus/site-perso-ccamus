<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		$erreur="";
		if ($_FILES['fichier']['error'] > 0) $erreur = "21";
		if ($_FILES['fichier']['size'] > 104857600) $erreur = "22";
		
		$fileName=preg_replace('/\s/', '', $_FILES['fichier']['name']);
		
		if(fileAlreadyExist($fileName)){
			$erreur = "23";
		}
				
		if($erreur!=""){
			redirAccueil($erreur);
		}else{
			$fileName=addFile($fileName);
			$resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],"donnes/".$fileName);
			enTete();
			
			if ($resultat) echo "Transfert réussi<br/> Vous pouvez maintenant faire un appel sur ce fichier en utilisant le chemin suivant :<br/>"."donnes/".$fileName;
		}
	}else{
		redirAccueil("9");
	}	
	basPage();
?>

