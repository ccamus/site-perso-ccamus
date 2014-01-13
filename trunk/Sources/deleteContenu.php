<?php

	session_start();
	include("functions.php");
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			include('functions/InstallInfo.php');
			enTete(null,$siteName." - suppression de contenu");
			echo '<form class="form-horizontal" role="form" method="post" action="DeleteContenuInBase.php">
						<legend>Suppression de contenu</legend>			
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="lienParent">Nom du lien :</label>
							<div class="col-sm-10">
								'.getLabels().'
							</div>
						</div>
						
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Supprimer !</button>
							</div>
						</div>
					</form>
					<br/><br/><br/>Si vous supprimez un lien parent, cela supprimera les liens fils.';
		}else{
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");	
	}	
	basPage();
?>
