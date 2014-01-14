<?php	
	include("functions/bdd.php");
	include('functions/other.php');
	include("functions/articles.php");
	include("functions/commentaire.php");
	include('functions/BlogReader.php');
	
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
		echo '<div class="row"><div class="col-md-1"></div><div class="col-md-10">';
		echo '<div class="panel panel-primary">';
		echo '<div class="panel-heading"><h3 class="panel-title"><a href="visuArticle.php?art='.$article->getIdArticle().'">'.$article->getTitre().'</a></h3></div>';
		echo '<div class="panel-body"><p class="pull-right"><span class="glyphicon glyphicon-calendar"></span> <small>'.$article->getDate().'</small></p><br/>';
		echo substr($contenu,0,700);
		if(strlen($contenu)>=700){	
			echo '...<span class="label label-primary"><a href="visuArticle.php?art='.$article->getIdArticle().'">Lire la suite</a></span>';
		}
		$nb=$article->getCountCommentaires();
		echo '<br/><small><a href="visuArticle.php?art='.$article->getIdArticle().'#com"><span class="badge badge-info">'.$nb.'</span> commentaire';
		if($nb>1){echo "s";}
		echo '</a></small>';
		echo '<p class="pull-right"><span class="glyphicon glyphicon-tag"></span> <small>'.$article->getTags().'</small></p></div>';
		echo '</div></div>';
		echo '<div class="col-md-1"></div></div>';
	}
	
	echo '<ul class="pager"><li class="previous';
	if(!$reader->asPreview()){
		echo ' disabled"><a href="#">&larr; Précédent</a></li>';
	}else{
		echo '"><a href="index.php?to=prev&amp;dat='.$reader->getFirstDate().'">&larr; Précédent</a></li>';
	}
	echo '<li class="next';
	if(!$reader->asNext()){
		echo ' disabled"><a href="#">Suivant &rarr;</a></li>';
	}else{
		echo '"><a href="index.php?to=nex&amp;dat='.$reader->getLastDate().'">Suivant &rarr;</a></li>';
	}
	echo '</ul>';
	
	
?>
