<?php
	include('functions/affichage.php');
	include('functions/contenus.php');	
	include('functions/InstallInfo.php');
	
	if(isset($_GET['page']) && is_numeric($_GET['page'])){
	include('functions/bdd.php');
		$contenu=recupContenuByID($_GET['page']);
		enTete($contenu['tags'],$siteName." - ".$contenu['label']);
		echo $contenu['contenu'];
	}else{
		//on affiche l'accueil
		enTete(null,$siteName." - Home");
		include('blog.php');
	}
	
	basPage();
?>
