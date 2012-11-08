<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut changer du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé			
			if(isset($_POST['contenu'])){
				//on cherche à enregistrer en base
				$retour=setHeadAccueil($_POST['contenu']);
				if($retour){
					redirAccueil("29");
				}else{
					redirAccueil("30");
				}
			}else{
				include('functions/InstallInfo.php');
				enTete(null,$siteName." - Changement de l\'en tête");
				
				//on cherche à modifier le contenu
				echo '<form class="form-horizontal" method="post" action="interfaceChangeHeadAccueil.php">
						<div class="controls">
							<legend>Modification du header d\'accueil</legend>
						</div>
						
						
						<div class="control-group">
							<label class="control-label" for="contenu">Nouveau header d\'accueil :</label>
							<div class="controls">
								<textarea name="contenu" id="contenu" rows="20" cols="100">'.getHeadAccueil().'</textarea>
							</div>
						</div>
						
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Envoyer !</button>
							</div>
						</div>
					</form><br/><br/><br/><br/>';
			}
		}else{
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");
	}
	basPage();
	
?>
