<?php
	include("functions.php");
	
	
	if(isset($_GET['page']) && is_numeric($_GET['page'])){
		$contenu=recupContenuByID($_GET['page']);
		enTete($contenu['tags'],"@Charlie - ".$contenu['label']);
		echo stripslashes($contenu['contenu']);
	}else{
		//on affiche l'accueil
		enTete(null,"@Charlie");
		include('blog.php');
	}
	
	basPage();
?>
