<?php
	session_start();
	
	include('functions/bdd.php');
	include('functions/affichage.php');
	include('functions/categorie.php');
	include('functions/gereUsers.php');
	include('functions/other.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		// Il est connecté !
		include('functions/InstallInfo.php');
		enTete(null,$siteName." - Gestion des catégories");
		
		echo '<form class="form-inline" role="form" method="post" action="gereCategorieAction.php?action=add">
				<legend>Ajout de catégorie</legend>
				<div class="form-group">
					<label class="sr-only" for="newCateg">Label de la catégorie</label>
					<input type="text" class="form-control" id="newCateg" placeholder="Label de la catégorie" name="labelNewCateg">
				</div>
				<button type="submit" class="btn btn-default" title="Créer la catégorie"><span class="glyphicon glyphicon-plus-sign"></span></button>
			</form><br/>';
		
		$categories = getAllCategories();
		
		if(count($categories)>0){
		
			echo '<br/><form class="form-horizontal" role="form" method="post" action="gereCategorieAction.php?action=md">
			
					<legend>Modifier/Supprimer des catégories</legend>';
			foreach($categories as $categorie){
					
				echo '<div class="form-group">
						<label for="labelCateg'.$categorie->getidCategorie().'" class="col-sm-2 control-label">Label de la catégorie</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="labelCateg'.$categorie->getidCategorie().'" placeholder="Label de la catégorie" name="labelCateg_'.$categorie->getidCategorie().'" value="'.$categorie->getLabelCategorie().'">
						</div>
						<div class="btn-group col-sm-1" data-toggle="buttons">
							<label class="btn btn-warning" title="Supprimer">
								<input type="checkbox" name="suppressor_'.$categorie->getidCategorie().'" value="supprimer">
								<span class="glyphicon glyphicon-plus-sign glyphicon-remove-sign"></span>
							</label>
						</div>
					</div>';
			}
			echo	'<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Sauvegarder</button>
						</div>
					</div>
				</form>';
		}
		
		basPage();
	}else{
		redirAccueil("9");
	}


?>