<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut changer du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			
			enTete();
			
			if(isset($_POST['articles']) && $_POST['articles']!=""){
				//interface de changement de contenu
				$_SESSION['articles']=$_POST['articles'];
				$article=new Article();
				$rep=$article->getArticleById($_POST['articles']);
				if($rep==""){
					echo '<form class="form-horizontal" method="post" action="modifyArticleInBase.php">
							<div class="controls">
								<legend>Modification d\'un article</legend>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="titreArticle">Titre de l\'article :</label>
								<div class="controls">
									<input type="text" name="titreArticle" id="titreArticle" value="'.$article->getTitre().'">
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="tag">Tags :</label>
								<div class="controls">
									<input type="text" name="tag" id="tag" value="'.$article->getTags().'">
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="contenu">Nouveau contenu :</label>
								<div class="controls">
									<textarea name="contenu" id="contenu" rows="20" cols="100">'.str_replace('<br/>',"\n",$article->getContenu()).'</textarea>
								</div>
							</div>
							
							
							<div class="control-group">
								<div class="controls">
									<button type="submit" class="btn">Envoyer !</button>
								</div>
							</div>
						</form><br/><br/><br/><br/>';
					echoStyle();
				}else{
					redirAccueil($rep);
				}
			}else{
				echo '<form class="form-horizontal" method="post" action="modifyArticle.php">
						<div class="controls">
							<legend>Modification d\'un article</legend>
						</div>
						
						
						<div class="control-group">
							<label class="control-label" for="articles">Titre de l\'article :</label>
							<div class="controls">
								'.listArticlesForModify().'
							</div>
						</div>
						
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Envoyer !</button>
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
