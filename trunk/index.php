<?php
	include("functions.php");
	
	
	if(isset($_GET['page']) && $contenu!="none"){
		$contenu=recupContenuByID($_GET['page']);
	}else{
		//on affiche l'accueil
		$contenu=recupContenuByID(0);
	}
	enTete($contenu['tags']);
	echo $contenu['contenu'];
	
	basPage();
?>
