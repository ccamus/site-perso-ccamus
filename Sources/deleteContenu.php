<?php

	session_start();
	include("functions.php");
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			enTete();
			echo '<form class="form-horizontal" method="post" action="DeleteContenuInBase.php">
						<div class="controls">
							<legend>Suppression de contenu</legend>
						</div>
						
						
						<div class="control-group">
							<label class="control-label" for="lienParent">Nom du lien :</label>
							<div class="controls">
								'.getLabels().'
							</div>
						</div>
						
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Supprimer !</button>
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
