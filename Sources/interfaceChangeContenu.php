<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut changer du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			
			enTete();
			
			if(isset($_POST['liens']) && $_POST['liens']!=""){
				//interface de changement de contenu
				$_SESSION['lien']=$_POST['liens'];
				$data=recupContenuByID($_POST['liens']);
				echo '<form class="form-horizontal" method="post" action="changeContenu.php">
						<div class="controls">
							<legend>Changement de contenu</legend>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="labelLien">Nom du lien :</label>
							<div class="controls">
								<input type="text" name="labelLien" id="labelLien" value="'.$data['label'].'">
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="tag">Tags :</label>
							<div class="controls">
								<input type="text" name="tag" id="tag" value="'.$data['tags'].'">
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="contenu">Nouveau contenu :</label>
							<div class="controls">
								<textarea name="contenu" id="contenu" rows="20" cols="100">'.str_replace('<br/>',"\n",$data['contenu']).'</textarea>
							</div>
						</div>
						
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Envoyer !</button>
							</div>
						</div>
					</form><br/><br/><br/><br/>';
				echoStyle();
			}else{
				echo '<form class="form-horizontal" method="post" action="interfaceChangeContenu.php">
						<div class="controls">
							<legend>Changement de contenu</legend>
						</div>
						
						
						<div class="control-group">
							<label class="control-label" for="liens">Lien du contenu à modifier :</label>
							<div class="controls">
								'.getLabels().'
							</div>
						</div>
						
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Envoyer !</button>
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
