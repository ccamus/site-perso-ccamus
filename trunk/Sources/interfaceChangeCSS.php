<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut changer du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé			
			if(isset($_POST['contenu'])){
				//on cherche à enregistrer en base
				$retour=setCss($_POST['contenu']);
				if($retour){
					redirAccueil("19");
				}else{
					redirAccueil("20");
				}
			}else{
				include('functions/InstallInfo.php');
				enTete(null,$siteName." - Modification du css");
				
				//on cherche à modifier le contenu
				echo '<form class="form-horizontal" method="post" action="interfaceChangeCSS.php">
						<div class="controls">
							<legend>Modification des style spéciaux</legend>
						</div>
						
						
						<div class="control-group">
							<label class="control-label" for="contenu">Nouveau CSS :</label>
							<div class="controls">
								<textarea name="contenu" id="contenu" rows="20" class="span6">'.getCss().'</textarea>
							</div>
						</div>
						
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Envoyer !</button>
							</div>
						</div>
					</form><br/><br/><br/><br/>
				<p>
						Ecrire les styles de la manière suivante :<br/>
						<table class="table">
							/* Définition du style */<br/>
							#nomStyle {<br/>
								données...<br/>
							}
						</table>
						Si aucun commentaire est entré, il n\'apparaîtra pas dans les styles disponibles.
					</p>';
			}
		}else{
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");
	}
	basPage();
	
?>
