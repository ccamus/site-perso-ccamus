<?php
	include("functions.php");
	
	
	if(isset($_GET['art']) && is_numeric($_GET['art'])){
		
		$article=new Article();
		$rep=$article->getArticleById($_GET['art']);
		if($rep==""){
			enTete($article->getTags());
			echo '<div class="page-header"><h1>'.$article->getTitre().'</h1></div><br/>';
			echo '<div class="well">';
			echo '<p class="pull-right"><i class="icon-calendar"></i> '.$article->getDate().'</p><br/><br/>';
			echo $article->getContenu();
			echo '<br/><br/><p class="pull-right"><i class="icon-tags"></i> '.$article->getTags().'</p><br/>';
			echo'</div>';
		}else{
			redirAccueil($rep);
		}
		
		basPage();
	}else{
		redirAccueil("28");
	}
	
?>
