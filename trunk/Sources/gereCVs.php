<?php
	session_start();
	
	include('functions/bdd.php');
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	include('functions/functionsCV.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
		//il est connecté?
		include('functions/InstallInfo.php');
		enTete(null,$siteName." - Gestion des CV");
		echo '<form class="form-inline" role="form" method="post" action="gereCVsAction.php?action=pdf" enctype="multipart/form-data">
				<legend>Gestion du CV au format PDF</legend>
				<div class="form-group">
					<label class="col-sm-5 control-label">Sélectionnez le fichier : </label>
					<div class="col-sm-5">
						<INPUT type="hidden" name="MAX_FILE_SIZE" value="104857600" class="form-control"/><INPUT type="file" name="fichier"/>
					</div>
				</div>
				<button type="submit" class="btn btn-default" title="Uploader le fichier">
					<span class="glyphicon glyphicon-cloud-upload"></span>
				</button>
			</form><br/>';
		
		echo '<form class="form-horizontal" role="form" method="post" action="gereCVsAction.php?action=chLong">
					<legend>Modification du CV long</legend>						
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="contenu">CV long :</label>
						<div class="col-sm-10">
							<textarea name="contenu" id="contenu" rows="20" class="form-control">'.getContenuCV(1).'</textarea>
						</div>
					</div>					
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Envoyer !</button>
						</div>
					</div>
						
				</form><br/><br/>';
		
		echo '<form class="form-horizontal" role="form" method="post" action="gereCVsAction.php?action=chCourt">
					<legend>Modification du CV court</legend>						
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="contenu">CV court :</label>
						<div class="col-sm-10">
							<textarea name="contenu" id="contenu" rows="20" class="form-control">'.getContenuCV(2).'</textarea>
						</div>
					</div>					
									
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Envoyer !</button>
						</div>
					</div>
						
				</form><br/><br/>';
		
		echo '<form class="form-horizontal" role="form" method="post" action="gereCVsAction.php?action=chEng">
					<legend>Modification du CV en anglais</legend>						
					
					<div class="form-group">
						<label class="col-sm-2 control-label" for="contenu">CV anglais :</label>
						<div class="col-sm-10">
							<textarea name="contenu" id="contenu" rows="20" class="form-control">'.getContenuCV(3).'</textarea>
						</div>
					</div>					
									
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Envoyer !</button>
						</div>
					</div>
						
				</form><br/><br/>';
	
		basPage();
	}else{
		redirAccueil("9");
	}

?>