<?php
	include('functions/affichage.php');
	include('functions/InstallInfo.php');
		
	//on affiche l'accueil
	enTete(null,$siteName." - Home");
	include('blog.php');
		
	basPage();
?>
