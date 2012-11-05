<?php
	include("functions.php");
	
	
	if(isset($_GET['page']) && is_numeric($_GET['page'])){
		$contenu=recupContenuByID($_GET['page']);
		enTete($contenu['tags']);
		echo stripslashes($contenu['contenu']);
	}else{
		//on affiche l'accueil
		enTete();
		include('blog.php');
	}
	
	basPage();
?>
