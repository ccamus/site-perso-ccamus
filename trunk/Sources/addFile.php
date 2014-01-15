<?php
	session_start();
	include('functions/bdd.php');
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/fichier.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		//il est connecté?
		include('functions/InstallInfo.php');
		enTete(null,$siteName." - Ajout de fichier");
		echo '<form class="form-horizontal" role="form" method="post" action="saveFile.php" enctype="multipart/form-data">
						<legend>Ajout de fichiers</legend>
						
						
						<div class="form-group">
							<label class="col-sm-2 control-label">Sélectionnez le fichier : </label>
							<div class="col-sm-10">
								<INPUT type=hidden name="MAX_FILE_SIZE" value="104857600" class="form-control"/><INPUT type=file name="fichier"/>
							</div>
						</div>
						
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Envoyer !</button>
							</div>
						</div>
					</form>';
		
	}else{
		redirAccueil("9");
	}	
	
	
	basPage();
?>
