<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		//il est connecté?
		include('functions/InstallInfo.php');
		enTete(null,$siteName." - Affichage des fichiers");
		
		echo '<h1>Liste des fichiers existants sur le serveur</h1><br/><br/><br/><br/>
		<form action="deleteFile.php" method="post">
		<table><th>Nom du fichier</th><th>Supprimer</th>';
		
		echo affiFiles();
		
		echo '<tr><td></td><td><input type="submit" value="Supprimer" /></td></tr>
		</table>
		</form>';
		
	}else{
		redirAccueil("9");
	}
	
	basPage();
?>
