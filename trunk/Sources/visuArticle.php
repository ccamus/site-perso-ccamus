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
			echo'</div><br/><section id="com">';
			
			$commentaires=$article->getCommentaires();
			foreach($commentaires as $commentaire){
				echo '<div class="row"><div class="span1"></div>';
				echo '<div class="span10"><div class="well well-small">';
				
				echo '<i class="icon-user"></i> '.$commentaire->getCommentateur();
				echo '<p class="pull-right"><i class="icon-calendar"></i> '.$commentaire->getDateComm().'</p><br/>';
				echo $commentaire->getCommentaire();
				
				echo '</div></div>';
				echo '<div class="span1"></div></div></section>
					';
			}
			
			echo'</section>';
			
		}else{
			redirAccueil($rep);
		}
		
		basPage();
	}else{
		redirAccueil("28");
	}
	
?>
