<?php

	session_start();
	include("functions.php");
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			include('functions/InstallInfo.php');
			enTete(null,$siteName." - Suppression d'article");
			echo '<form class="form-horizontal" method="post" action="DeleteArticleInBase.php">
						<div class="controls">
							<legend>Suppression d\'article</legend>
						</div>
						
						
						<div class="control-group">
							<label class="control-label" for="articles">Titre de l\'article :</label>
							<div class="controls">
								'.listArticlesForModify().'
							</div>
						</div>
						
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Supprimer !</button>
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
