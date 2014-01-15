<?php
	session_start();
	
	include('functions/bdd.php');
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	
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
				echo '<form class="form-horizontal" role="form" method="post" action="interfaceChangeCSS.php">
						<legend>Modification des style spéciaux</legend>
						
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="contenu">Nouveau CSS :</label>
							<div class="col-sm-10">
								<textarea name="contenu" id="contenu" rows="20" class="form-control">'.getCss().'</textarea>
							</div>
						</div>
						
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Envoyer !</button>
							</div>
						</div>
					</form><br/><br/><br/><br/>
				<p>
						Ecrire les styles de la manière suivante :<br/>
							/* Définition du style */<br/>
							#nomStyle {<br/>
								données...<br/>
							}<br/>
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
