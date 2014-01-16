<?php

	include('functions/other.php');
	include('functions/affichage.php');
	include('functions/InstallInfo.php');
	
	if(isset($_GET['cv']) 
		&& ($_GET['cv'] == "1"
			|| $_GET['cv'] == "2"
			|| $_GET['cv'] == "3")){
		// Tout va bien, on continue
		
		switch ($_GET['cv']) {
			case 1:
				enTete("cv, long, ".$nom.", ".$prenom,$siteName." - CV long");
				include("CV/cvLong.html");
				break;
			case 2:
				enTete("cv, court, ".$nom.", ".$prenom,$siteName." - CV court");
				include("CV/cvCourt.html");
				break;
			case 3:
				enTete("cv, english, anglais, ".$nom.", ".$prenom,$siteName." - English CV");
				include("CV/cvAnglais.html");
				break;
		}
		basPage();
	} else {
		// Erreur !
		redirAccueil("10");
	}

?>