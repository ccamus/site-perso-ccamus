<?php
	session_start();
	include("functions.php");
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut ajouter du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			enTete();
			echo(getAdminControl());
		}else{
			redirAccueil("9");
		}
	}else{
		if(isset($_POST['pseudo']) && isset($_POST['pass']) && $_POST['pseudo']!="" && $_POST['pass']!=""){
			//il a essayé de se connecter, on vérifie si il a le droit
			if(isExist($_POST['pseudo'],md5($_POST['pass']))){
				$_SESSION['userName']=$_POST['pseudo'];
				$_SESSION['pwd']=md5($_POST['pass']);
				//il existe et est authorisé
				enTete();
				echo(getAdminControl());
			}else{
				redirAccueil("9");
			}
			
		}else{			
			// il veut se connecter
			enTete();
			echo '<div class="container">			
			<div class="row">
				<div class="span6">
									
					<form class="form-horizontal" method="post" action="adminInterface.php">
						<div class="controls">
							<legend>Connexion administrateur</legend>
						</div>
						<div class="control-group">
							<label class="control-label" for="pseudo">Nom de connexion</label>
							<div class="controls">
								<input type="text" name="pseudo" id="pseudo" placeholder="Nom de connexion">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="pass">Mot de passe</label>
							<div class="controls">
								<input type="password" name="pass" id="pass" placeholder="Mot de passe">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<button type="submit" class="btn">Envoyer !</button>
							</div>
						</div>
					</form>
				
				</div>
				
				<div class="span6">
					
					<p>
						<h2>Administration et gestion de contenus</h2>
						<p>La connexion administrateur permet d\'ajouter/modifier/supprimer du contenu, en fonction duquel le menu est généré. L\'interface permet aussi d\'ajouter et supprimer des fichiers en ligne. Enfin il est possible de gérer des styles personnalisés qui seront par la suite proposés durant l\'édition de contenus.</p>
					</p>
				
				</div>
			</div>
		</div>';
		}
	}
	basPage();
	
	function getAdminControl(){
		return '<div class="container">			
					<h1>Interface d\'administration</h1><br/><br/><br/>
					<div class="row">
						<div class="span6">
							
							<div class="controls">
								<legend>Gestion des articles</legend>
							</div>
							
							<i class="icon-pencil"></i> <a href="ajoutArticle.php">Ajouter un article</a><br/>
							<i class="icon-folder-open"></i> <a href="modifyArticle.php">Modifier un article</a><br/>
							<i class="icon-trash"></i> <a href="deleteArticle.php">Supprimer un article</a><br/>
							
						</div>
								
						<div class="span6">
							
							<div class="controls">
								<legend>Gestion du contenu</legend>
							</div>
							<i class="icon-pencil"></i> <a href="ajouContenu.php">Ajouter du Contenu</a><br/>
							<i class="icon-folder-open"></i> <a href="interfaceChangeContenu.php">Changer du Contenu</a><br/>
							<i class="icon-trash"></i> <a href="deleteContenu.php">Supprimer du Contenu</a><br/>
							<br/><br/>
							<i class="icon-upload"></i> <a href="addFile.php">Envoyer un fichier sur le serveur</a><br/>
							<i class="icon-trash"></i> <a href="affiFile.php">Voir et/ou supprimer des fichiers sur le serveur</a><br/>
							<br/><br/>
							<i class="icon-picture"></i> <a href="interfaceChangeCSS.php">Modifier les styles personnalisés</a><br/>
							<i class="icon-picture"></i> <a href="interfaceChangeHeadAccueil.php">Modifier le header d\'accueil</a><br/>
							
						</div>
					</div>
					<br/><br/>
					<div align="center"><a href="deco.php" class="btn btn-large btn-info">Se déconnecter</a></div>
				</div>';
	}
	
?>
