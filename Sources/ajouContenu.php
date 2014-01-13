<?php

	session_start();
	include("functions.php");
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			
			include('functions/InstallInfo.php');
			enTete(null,$siteName." - Ajout de contenu");
			echo '<form class="form-horizontal" role="form" method="post" action="insertContenuInBase.php">
						<legend>Insertion de contenu</legend>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="labelLien">Nom du lien :</label>
							<div class="col-sm-10">
								<input type="text" name="labelLien" id="labelLien" placeholder="Label du lien" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="lienParent">Lien parent :</label>
							<div class="col-sm-10">
								'.getLabelParent().'
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="tag">Tags :</label>
							<div class="col-sm-10">
								<input type="text" name="tag" id="tag" placeholder="Tag du lien" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="contenu">Contenu :</label>
							<div class="col-sm-10">
								<textarea name="contenu" id="contenu" class="form-control"></textarea>
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
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");
	}	
	basPage();
?>
