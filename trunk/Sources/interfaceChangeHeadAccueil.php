<?php
	session_start();
	
	include('functions/bdd.php');
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/contenus.php');
	
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
				echo '<form class="form-horizontal" role="form" method="post" action="interfaceChangeHeadAccueil.php">
						<legend>Modification du header d\'accueil</legend>						
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="contenu">Nouveau header d\'accueil :</label>
							<div class="col-sm-10">
								<textarea name="contenu" id="contenu" rows="20" class="form-control">'.getHeadAccueil().'</textarea>
							</div>
						</div>
						
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Envoyer !</button>
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
