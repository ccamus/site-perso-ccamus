<?php
	session_start();
	
	include('functions/bdd.php');
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/contenus.php');
	include('functions/articles.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut changer du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			include('functions/InstallInfo.php');
			enTete(null,$siteName." - Modification d'article");
			
			if(isset($_POST['articles']) && $_POST['articles']!=""){
				//interface de changement de contenu
				$_SESSION['articles']=$_POST['articles'];
				$article=new Article();
				$rep=$article->getArticleById($_POST['articles']);
				if($rep==""){
					echo '<form class="form-horizontal" role="form" method="post" action="modifyArticleInBase.php">
							<legend>Modification d\'un article</legend>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="titreArticle">Titre de l\'article :</label>
								<div class="col-sm-10">
									<input type="text" name="titreArticle" id="titreArticle" value="'.$article->getTitre().'" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="tag">Tags :</label>
								<div class="col-sm-10">
									<input type="text" name="tag" id="tag" value="'.$article->getTags().'" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="contenu">Nouveau contenu :</label>
								<div class="col-sm-10">
									<textarea name="contenu" id="contenu" rows="20" class="form-control">'.str_replace('<br/>',"\n",$article->getContenu()).'</textarea>
								</div>
							</div>
							
							
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default">Envoyer !</button>
								</div>
							</div>
						</form><br/><br/><br/><br/>';
					echoStyle();
				}else{
					redirAccueil($rep);
				}
			}else{
				echo '<form class="form-horizontal" role="form" method="post" action="modifyArticle.php">
						<legend>Modification d\'un article</legend>
						
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="articles">Titre de l\'article :</label>
							<div class="col-sm-10">
								'.listArticlesForModify().'
							</div>
						</div>
						
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Envoyer !</button>
							</div>
						</div>
					</form>';
			}
		}else{
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");
	}
	basPage();
	
?>
