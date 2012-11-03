<?php
	include("functions.php");
	enTete();
	$next=true;
	if(isset($_GET['to']) && $_GET['to']=='prev'){
		$next=false;
	}
	
	if(isset($_GET['last']) && is_numeric($_GET['last']) && strlen($_GET['last'])==14){
		$reader=new BlogReader($_GET['last']);
	}else{
		$reader=new BlogReader();
	}
	
	$arrayArticles = $reader->getEight($next);

	foreach($arrayArticles as $article){
		echo '<div class="page-header"><a href="visuArticle.php?art='.$article->getIdArticle().'"><h2>'.$article->getTitre().'</h2></a></div>';
		echo '<div class="well">';
		echo '<p class="pull-right"><i class="icon-calendar"></i> '.$article->getDate().'</p><br/>';
		echo $article->getContenu();
		echo '<br/><p class="pull-right"><i class="icon-tags"></i> '.$article->getTags().'</p><br/>';
		echo'</div>';
	}
	
	echo '<ul class="pager"><li class="previous';
	if(!$reader->asPreview()){
		echo ' disabled"><a href="#">&larr; Précédent</a></li>';
	}else{
		echo '"><a href="blog.php?to=prev&last='.$reader->getLastDate().'">&larr; Précédent</a></li>';
	}
	echo '<li class="next';
	if(!$reader->asNext()){
		echo ' disabled"><a href="#">Suivant &rarr;</a></li>';
	}else{
		echo '"><a href="blog.php?to=nex&last='.$reader->getLastDate().'">Suivant &rarr;</a></li>';
	}
	
	
	basPage();
?>
