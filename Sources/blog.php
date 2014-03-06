<?php	
	include("functions/bdd.php");
	include('functions/other.php');
	include("functions/articles.php");
	include("functions/commentaire.php");
	include('functions/BlogReader.php');
	include('functions/categorie.php');
	include('functions/messages.php');
	
	$next=true;
	// Si on a fait un "précédent", next = false sinon, on est en mode suivant
	if(isset($_GET['to']) && $_GET['to']=='prev'){
		$next=false;
	}	
	
	$mode = null;
	$data = null;
	if(isset($_GET['mod']) && (
		$_GET['mod'] == "date" ||
		$_GET['mod'] == "categ" ) &&
		isset($_GET['data']) &&
		$_GET['data'] != ""){
		// Ici on a un mode de recherche date ou catégorie
		$mode = $_GET['mod'];
		$data = $_GET['data'];
	}else if(isset($_GET['mod']) 
		&& $_GET['mod'] == "search"
		&& (( isset($_POST['searchWords'])
		&& $_POST['searchWords']!="" )
		|| ( isset($_GET['data'])
		&& $_GET['data']!="" ))){
		// Ici on a un mode de recherche search
		$mode = $_GET['mod'];
		if(isset($_POST['searchWords'])
			&& $_POST['searchWords']!=""){
			$data = $_POST['searchWords'];
		}else{
			$data = $_GET['data'];
		}
	}
	
	// Si on a une date, ça veut dire qu'on navigue depuis une page, sinon on vient juste d'arriver sur la page
	if(isset($_GET['dat']) && is_numeric($_GET['dat']) && strlen($_GET['dat'])==14){
		if($next){
			$reader=new BlogReader("",$_GET['dat'],$mode,$data);
		}else{
			$reader=new BlogReader($_GET['dat'],"",$mode,$data);
		}
	}else{
		$reader=new BlogReader("","",$mode,$data);
	}
	
	$arrayArticles = $reader->getEight($next);
	if(sizeof($arrayArticles)==0){
		$arrayArticles = $reader->getEight($next);
	}
	
	if(sizeof($arrayArticles)==0 || (!(isset($_GET['dat']) && is_numeric($_GET['dat']) && strlen($_GET['dat'])==14))){
		echo getHeadAccueil();
	}
	
	$toAffich = "";
	$alert = false;
	
	// Création de l'accordéon
	$toAffich .= '<div class="row"><div class="col-md-3">';
	$toAffich .= '<div class="panel-group" id="accordion">';
	// Tri par date
	$lesMoisAnnees = getMoisArticles();
	if(count($lesMoisAnnees)>0){
		$lesLi="";
		$array = array('janvier', 'fevrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'aout', 'septembre', 'octobre', 'novembre', 'decembre');
		foreach($lesMoisAnnees as $moisAnnee){
			$mois = substr($moisAnnee,0,2);
			$annee = substr($moisAnnee,3);
			$lesLi .= '<li><a href="index.php?mod=date&amp;data='.$mois.$annee.'">'.$array[$mois-1].' '.$annee.'</a></li>';
		}
		$toAffich .= createPanelAccordeon('Sélection par date'
						,'<ul class="nav nav-pills nav-stacked">'.$lesLi.'</ul>'
						,'accordion'
						, 'collapseOne');
	}
	// Tri par catégorie
	$categories = getAllCategories();
	if(count($categories)>0){
		$lesLi="";
		foreach($categories as $categorie){
			$lesLi .= '<li><a href="index.php?mod=categ&amp;data='.$categorie->getIdCategorie().'">'.$categorie->getLabelCategorie().'</a></li>';
		}
		$toAffich .= createPanelAccordeon('Sélection par catégorie'
						,'<ul class="nav nav-pills nav-stacked">'.$lesLi.'</ul>'
						,'accordion'
						, 'collapseTwo');
	}
	// Flux rss
	$toAffich .= createPanelAccordeon('Flux RSS'
						,'<ul class="nav nav-pills nav-stacked"><a href="RSS/articlesFeed.xml" target="_blank"><img src="libraries/glyphicons_social_37_rss.png"></img> Flux des articles</a><br/><br/><a href="RSS/commentairesFeed.xml" target="_blank"><img src="libraries/glyphicons_social_37_rss.png"></img> Flux des commentaires</a></ul>'
						,'accordion'
						, 'collapseThree');
	// Fermeture de l'accordéon
	$toAffich .= '</div></div><div class="col-md-9">';
	
	// Création des panels blog
	foreach($arrayArticles as $article){		
		$categorie = getCategorieByIdCategorie($article->getIdCategorie());

		if($categorie != null ){
			$toAffich .= '<div class="row"><div class="col-md-12">';
			$toAffich .= '<div class="panel panel-primary">';
			$toAffich .= '<div class="panel-heading"><h3 class="panel-title"><a href="visuArticle.php?art='.$article->getIdArticle().'">'.$article->getTitre().'</a></h3></div>';
			$toAffich .= '<div class="panel-body">';
			$toAffich .= '<span class="glyphicon glyphicon-book" title="Cat&eacute;gorie"></span> '.$categorie->getLabelCategorie();
			$toAffich .= '<p class="pull-right"><span class="glyphicon glyphicon-calendar"></span> <small>'.$article->getDate().'</small></p><br/><br/>';
			$toAffich .= substr($article->getContenu(),0,700);
			if(strlen($article->getContenu())>=700){	
				$toAffich .= '...<span class="label label-primary"><a href="visuArticle.php?art='.$article->getIdArticle().'">Lire la suite</a></span>';
			}
			$nb=$article->getCountCommentaires();
			$toAffich .= '<br/><small><a href="visuArticle.php?art='.$article->getIdArticle().'#com"><span class="badge">'.$nb.'</span> commentaire';
			if($nb>1){$toAffich .= "s";}
			$toAffich .= '</a></small>';
			$toAffich .= '<p class="pull-right"><span class="glyphicon glyphicon-tag"></span> <small>'.$article->getTags().'</small></p></div>';
			$toAffich .= '</div></div>';
			$toAffich .= '</div>';
		}else{
			// Il y a un problème de récupération de catégorie
			$toAffich = '<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<h4>Erreur!</h4>'.$msgs[42].'</div>';
			$alert = true;
			break;
		}
		$categorie = null;
	}
	if(!$alert){
		$toAffich .= '</div></div>';
	}
	
	echo $toAffich;
	
	if(!$alert){
		// S'il n'y a pas d'alert, on affiche la pagination
		$infoLienMode="";
		if(isset($mode)){
			// Si on a un mode d'actif, on l'insère dans le lien
			$infoLienMode='&amp;mod='.$mode.'&amp;data='.rawurlencode($data);
		}
		
		echo '<ul class="pager"><li class="previous';
		if(!$reader->asPreview()){
			echo ' disabled"><a href="#">&larr; Précédent</a></li>';
		}else{
			echo '"><a href="index.php?to=prev&amp;dat='.$reader->getFirstDate();
			echo $infoLienMode.'">&larr; Précédent</a></li>';
		}
		echo '<li class="next';
		if(!$reader->asNext()){
			echo ' disabled"><a href="#">Suivant &rarr;</a></li>';
		}else{
			echo '"><a href="index.php?to=nex&amp;dat='.$reader->getLastDate();
			echo $infoLienMode.'">Suivant &rarr;</a></li>';
		}
		echo '</ul>';
	}
	
	
?>
