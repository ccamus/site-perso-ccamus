<?php

	session_start();
	include("functions.php");
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			
			enTete(null,"Ajout de contenu");
			echo '<form class="form-horizontal" method="post" action="insertContenuInBase.php">
						<div class="controls">
							<legend>Insertion de contenu</legend>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="labelLien">Nom du lien :</label>
							<div class="controls">
								<input type="text" name="labelLien" id="labelLien" placeholder="Label du lien">
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="lienParent">Lien parent :</label>
							<div class="controls">
								'.getLabelParent().'
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="tag">Tags :</label>
							<div class="controls">
								<input type="text" name="tag" id="tag" placeholder="Tag du lien">
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="contenu">Contenu :</label>
							<div class="controls">
								<textarea name="contenu" id="contenu" rows="20" cols="100"></textarea>
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Envoyer !</button>
							</div>
						</div>
					
				</form>
				<br/><br/><br/>';
				echoStyle();
		}else{
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");
	}	
	basPage();
?>
