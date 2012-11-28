<?php	
	$next=true;
	if(isset($_GET['to']) && $_GET['to']=='prev'){
		$next=false;
	}
	
	if(isset($_GET['dat']) && is_numeric($_GET['dat']) && strlen($_GET['dat'])==14){
		if($next){
			$reader=new BlogReader("",$_GET['dat']);
		}else{
			$reader=new BlogReader($_GET['dat'],"");
		}
	}else{
		$reader=new BlogReader();
	}
	
	$arrayArticles = $reader->getEight($next);
	if(sizeof($arrayArticles)==0){
		$arrayArticles = $reader->getEight($next);
	}
	
	if(sizeof($arrayArticles)==0 || (!(isset($_GET['dat']) && is_numeric($_GET['dat']) && strlen($_GET['dat'])==14))){
		echo getHeadAccueil();
	}

	foreach($arrayArticles as $article){
		$contenu=$article->getContenu();
		echo '<div class="row"><div class="span1"></div>';
		echo '<div class="span10"><div class="well">';
		echo '<p class="pull-right"><i class="icon-calendar"></i> <small>'.$article->getDate().'</small></p>';
		echo '<a href="visuArticle.php?art='.$article->getIdArticle().'"><h2>'.$article->getTitre().'</h2></a>';
		echo substr($contenu,0,700);
		if(strlen($contenu)>=700){	
			echo '...<span class="label label-default"><a href="visuArticle.php?art='.$article->getIdArticle().'">Lire la suite</a></span>';
		}
		$nb=$article->getCountCommentaires();
		echo '<br/><small><a href="visuArticle.php?art='.$article->getIdArticle().'#com"><span class="badge badge-info">'.$nb.'</span> commentaire';
		if($nb>1){echo "s";}
		echo '</a></small>';
		echo '<p class="pull-right"><i class="icon-tags"></i> <small>'.$article->getTags().'</small></p><br/>';
		echo '</div></div>';
		echo '<div class="span1"></div></div>
			';
	}
	
	echo '<ul class="pager"><li class="previous';
	if(!$reader->asPreview()){
		echo ' disabled"><a href="#">&larr; Précédent</a></li>';
	}else{
		echo '"><a href="index.php?to=prev&dat='.$reader->getFirstDate().'">&larr; Précédent</a></li>';
	}
	echo '<li class="next';
	if(!$reader->asNext()){
		echo ' disabled"><a href="#">Suivant &rarr;</a></li>';
	}else{
		echo '"><a href="index.php?to=nex&dat='.$reader->getLastDate().'">Suivant &rarr;</a></li>';
	}
	
	
?>
