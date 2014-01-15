<?php
	session_start();
	include('functions/bdd.php');
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/fichier.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		//il est connecté?
		include('functions/InstallInfo.php');
		enTete(null,$siteName." - Affichage des fichiers");
		
		echo '<form class="form-horizontal" role="form" action="deleteFile.php" method="post">
		<legend>Fichiers présents</legend>';
		
		foreach(getFiles() as $fichier){
			echo '<div class="form-group">
						<div class="col-sm-6">
							<a href="'.$fichier->getChemin().'">
								'.$fichier->getNom().'
							</a>
						</div>
						<div class="btn-group col-sm-2" data-toggle="buttons">
							<label class="btn btn-warning" title="Supprimer">
								<input type="checkbox" name="'.$fichier->getId().'">
								<span class="glyphicon glyphicon-plus-sign glyphicon-remove-sign"></span>
							</label>
						</div>
					</div>';
		}
		
		echo '<div class="form-group">
					<div class="col-sm-offset-6 col-sm-2">
						<input type="submit" class="btn btn-default value="Supprimer" />
					</div>
				</div>
		</form>';
		
	}else{
		redirAccueil("9");
	}
	
	basPage();
?>
