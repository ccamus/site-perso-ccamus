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
			
			include('functions/InstallInfo.php');
			enTete(null,$siteName." - Modification de contenu");
			
			if(isset($_POST['liens']) && $_POST['liens']!=""){
				//interface de changement de contenu
				$_SESSION['lien']=$_POST['liens'];
				$data=recupContenuByID($_POST['liens']);
				echo '<form class="form-horizontal" role="form" method="post" action="changeContenu.php">
						<legend>Changement de contenu</legend>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="labelLien">Nom du lien :</label>
							<div class="col-sm-10">
								<input type="text" name="labelLien" id="labelLien" value="'.$data['label'].'" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="tag">Tags :</label>
							<div class="col-sm-10">
								<input type="text" name="tag" id="tag" value="'.$data['tags'].'" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="contenu">Nouveau contenu :</label>
							<div class="col-sm-10">
								<textarea name="contenu" id="contenu" rows="20" class="form-control">'.str_replace('<br/>',"\n",$data['contenu']).'</textarea>
							</div>
						</div>
						
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Envoyer !</button>
							</div>
						</div>
					</form><br/><br/><br/><br/>';
				echoStyle();
			}else{
				echo '<form class="form-horizontal" role="form" method="post" action="interfaceChangeContenu.php">
						<legend>Changement de contenu</legend>
						
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="liens">Lien du contenu à modifier :</label>
							<div class="col-sm-10">
								'.getLabels().'
							</div>
						</div>
						
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Envoyer !</button>
							</div>
						</div>
					</form>';
			}
		}else{
			redirAccueil("9");
		}
	}else{
		redirAccueil("9");
	}
	basPage();
	
?>
