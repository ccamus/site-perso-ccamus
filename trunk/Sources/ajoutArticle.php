<?php

	session_start();
	include('functions/bdd.php');
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/categorie.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			$categories = getAllCategories();
			if(count($categories)>0){
				// il y a des catégories, on y va !!!
				include('functions/InstallInfo.php');
				enTete(null,$siteName." - Ajout d'article");
				echo '<form class="form-horizontal" role="form" method="post" action="insertArticleInBase.php">
							<legend>Insertion de contenu</legend>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="titreArticle">Titre de l\'article :</label>
								<div class="col-sm-10">
									<input type="text" name="titreArticle" id="titreArticle" placeholder="Titre de l\'article" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="categ">Catégorie :</label>
								<div class="col-sm-10">
									<select class="form-control" name="categorie" id="categ">';
				
				foreach($categories as $categorie){
					echo '<option value="'.$categorie->getIdCategorie().'">'.$categorie->getLabelCategorie().'</option>';
				}
				echo '				</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="tag">Tags :</label>
								<div class="col-sm-10">
									<input type="text" name="tag" id="tag" placeholder="Tags de l\'article" class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="contenu">Contenu :</label>
								<div class="col-sm-10">
									<textarea name="contenu" id="contenu" rows="20" class="form-control"></textarea>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<label class="checkbox">
										<input type="checkbox" name="tweet" id="tweet" value="tweet"> Tweet it !
									</label>
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default">Envoyer !</button>
								</div>
							</div>
						
					</form>
					<br/><br/><br/>';
				echoStyle();
			}else{
				redirAccueil("41");
			}
		}else{
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");
	}	
	basPage();
?>
