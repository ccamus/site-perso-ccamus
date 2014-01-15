<?php

	session_start();
	
	include('functions/bdd.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/affichage.php');
	include('functions/articles.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			include('functions/InstallInfo.php');
			enTete(null,$siteName." - Suppression d'article");
			echo '<form class="form-horizontal" role="form" method="post" action="DeleteArticleInBase.php">
						<legend>Suppression d\'article</legend>
												
						<div class="form-group">
							<label class="col-sm-2 control-label" for="articles">Titre de l\'article :</label>
							<div class="col-sm-10">
								'.listArticlesForModify().'
							</div>
						</div>
						
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Supprimer !</button>
							</div>
						</div>
					</form>';
		}else{
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");	
	}	
	basPage();
?>
