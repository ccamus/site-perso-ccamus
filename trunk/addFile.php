<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		//il est connecté?
		enTete();
		echo '<form class="form-horizontal" method="post" action="saveFile.php" enctype="multipart/form-data">
						<div class="controls">
							<legend>Ajout de fichiers</legend>
						</div>
						
						
						<div class="control-group">
							<label class="control-label">Sélectionnez le fichier : </label>
							<div class="controls">
								<INPUT type=hidden name="MAX_FILE_SIZE" value="104857600"/><INPUT type=file name="fichier"/>
							</div>
						</div>
						
						
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Envoyer !</button>
							</div>
						</div>
					</form>';
		
	}else{
		redirAccueil("9");
	}	
	
	
	basPage();
?>
