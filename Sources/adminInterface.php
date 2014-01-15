<?php
	session_start();
	include("functions/bdd.php");
	include('functions/InstallInfo.php');
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/gereUsers.php');
	
	if(isset($_SESSION['userName']) && isset($_SESSION['pwd'])){
		//il veut ajouter du contenu, le peut il?
		if(isExist($_SESSION['userName'],$_SESSION['pwd'])){
			//il existe et est authorisé
			enTete(null,$siteName." - Interface d'administration");
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
				enTete(null,$siteName." - Interface d'administration");
				echo(getAdminControl());
			}else{
				redirAccueil("9");
			}
			
		}else{			
			// il veut se connecter
			enTete(null,$siteName." - Interface d'administration");
			echo '<div class="container">			
			<div class="row">
				<div class="col-md-6">
									
					<form class="form-horizontal" role="form" method="post" action="adminInterface.php">
						<div class="form-group">
							<legend>Connexion administrateur</legend>
							
							<div class="form-group">
								<label class="col-sm-2 control-label" for="pseudo">Nom de connexion</label>
								<div class="col-sm-10">
									<input type="text" name="pseudo" id="pseudo" placeholder="Nom de connexion" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="pass">Mot de passe</label>
								<div class="col-sm-10">
									<input type="password" name="pass" id="pass" placeholder="Mot de passe" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
								  <button type="submit" class="btn btn-default">Connexion</button>
								</div>
							</div>
						</div>
					</form>
				
				</div>
				
				<div class="col-md-6">
					
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
						<div class="col-md-6">
							
							<div class="controls">
								<legend>Gestion des articles</legend>
							</div>
							
							<span class="glyphicon glyphicon-book"></span> <a href="gereCategories.php">Gérer les catégories</a><br/>
							<br/><br/>
							<span class="glyphicon glyphicon-pencil"></span><a href="ajoutArticle.php">Ajouter un article</a><br/>
							<span class="glyphicon glyphicon-folder-open"></span> <a href="modifyArticle.php">Modifier un article</a><br/>
							<span class="glyphicon glyphicon-trash"></span></i> <a href="deleteArticle.php">Supprimer un article</a><br/>
							<br/><br/>
							<div class="controls">
								<legend>Gestion des Commentaires</legend>
							</div>
							
							La gestion des commentaires se fait sur la page de visualisation des articles.
							
						</div>
								
						<div class="col-md-6">
							
							<div class="controls">
								<legend>Gestion du contenu</legend>
							</div>
							<span class="glyphicon glyphicon-upload"></span> <a href="addFile.php">Envoyer un fichier sur le serveur</a><br/>
							<span class="glyphicon glyphicon-trash"></span> <a href="affiFile.php">Voir et/ou supprimer des fichiers sur le serveur</a><br/>
							<br/><br/>
							<span class="glyphicon glyphicon-picture"></span> <a href="interfaceChangeCSS.php">Modifier les styles personnalisés</a><br/>
							<span class="glyphicon glyphicon-picture"></span> <a href="interfaceChangeHeadAccueil.php">Modifier le header d\'accueil</a><br/>
							
						</div>
					</div>
					<br/><br/>
					<div align="center"><a href="deco.php" class="btn btn-large btn-danger">Se déconnecter</a></div>
				</div>';
	}
	
?>
