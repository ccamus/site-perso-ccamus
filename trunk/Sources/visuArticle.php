<?php
	session_start();
	
	include("functions/bdd.php");
	include('functions/affichage.php');
	include('functions/other.php');
	include('functions/articles.php');
	include('functions/commentaire.php');
	include('functions/categorie.php');
		
	if(isset($_GET['art']) && is_numeric($_GET['art'])){
		
		$article=new Article();
		$rep=$article->getArticleById($_GET['art']);
		if($rep==""){
			
			$categorie = getCategorieByIdCategorie($article->getIdCategorie());
			if($categorie != null ){
				// La catégorie existe, tout va bien.
			
				include('functions/InstallInfo.php');
				enTete($article->getTags(),$siteName." - ".$article->getTitre());
				
				//affichage de l'article
				echo '<div class="page-header"><h1>'.$article->getTitre().'</h1></div><br/>';
				echo '<div class="well">';
				echo '<span class="glyphicon glyphicon-book" title="Cat&eacute;gorie"></span> '.$categorie->getLabelCategorie();
				echo '<p class="pull-right"><span class="glyphicon glyphicon-calendar" title="Date de l\'article"></span> '.$article->getDate().'</p><br/><br/>';
				echo $article->getContenu();
				echo '<br/><br/><p class="pull-right"><span class="glyphicon glyphicon-tag" title="Tags de l\'article"></span> '.$article->getTags().'</p><br/>';
				echo'</div><br/><section id="com"></section><br/>';
				
				//affichage des commentaires
				if($commActifs){
					$commentaires=$article->getCommentaires();
					$isAdmin=false;
					if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
						$isAdmin=true;
					}
					foreach($commentaires as $commentaire){
						echo '<div class="row"><div class="col-sm-1"></div>';
						echo '<div class="col-sm-10"><div class="panel panel-default"><div class="panel-body">';
						
						echo '<span class="glyphicon glyphicon-user"></span> <small>'.$commentaire->getCommentateur().'</small>';
						echo '<p class="pull-right"><span class="glyphicon glyphicon-calendar"></span> <small>'.$commentaire->getDateComm().'</small></p><br/>';
						echo $commentaire->getCommentaire();
						if($isAdmin){
							//C'est un admin ?
							echo '<br/><p class="pull-right"><small><a href="deleteComm.php?com='.$commentaire->getIdCommentaire().'&art='.$_GET['art'].'">Supprimer</a></small></p>';
						}
						
						echo '</div></div></div>';
						echo '<div class="col-sm-1"></div></div>
							';
					}
					
					echo '</section>';
					
					//partie insertion de commentaire
					echo '<section id="addCom"><br/><div class="row"><div class="span2"></div>';
					echo '<div class="span8"><div class="well well-small">';
					echo '<span class="glyphicon glyphicon-comment"></span> <small>Ajouter un commentaire</small>';
					
					echo '<form class="form-horizontal" role="form" method="post" action="addComment.php?art='.$_GET['art'].'">';
					echo '<div class="form-group">
							<label class="col-sm-2 control-label" for="commentateur">Votre nom :</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="commentateur" id="commentateur" placeholder="Votre nom" value="';
					//si il y a un nom en session on prends
					if(isset($_SESSION['nomCommentateur'])){
						echo $_SESSION['nomCommentateur'];
					}
					echo		'">
							</div>
						</div>';
								
					echo '<div class="form-group">
							<label class="col-sm-2 control-label" for="commentaire">Votre commentaire :</label>
							<div class="col-sm-10">
								<textarea name="commentaire" id="commentaire" placeholder="Votre commentaire" rows="3" class="form-control">';
					//si il y a un commentaire en session on prends		
					if(isset($_SESSION['commentaire'])){
						echo $_SESSION['commentaire'];
					}
					echo		'</textarea>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
							  <div class="checkbox">
								<label id="labelCheckBot">
								  
								</label>
							  </div>
							</div>
						</div>
						<input type="hidden" name="email" value="" /> 
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Envoyer !</button>
							</div>
						</div>
						</form>
						
						</div></div>
						<div class="span2"></div></div></section>
						
						<script type="text/javascript">
							var labelCheckBot = document.getElementById("labelCheckBot");
						
							var baliseAAjouter = document.createElement("input");
							baliseAAjouter.setAttribute("type","checkbox");
							baliseAAjouter.setAttribute("name","checkBot");
							baliseAAjouter.setAttribute("value","notBot");
							labelCheckBot.innerHTML+="Merci de cocher cette case afin de montrer que vous n\'&#234;tes pas un robot.";
						
							labelCheckBot.appendChild(baliseAAjouter);
						</script>';
					
					//si le mec est pas logué, on détruit la session
					if(!$isAdmin){
						session_destroy();
						$_SESSION = array();
					}else{
						$_SESSION['nomCommentateur']="";
						$_SESSION['commentaire']="";
					}
				}
				
				if(isset($_GET['message']) && $_GET['message']!=''){
					include('functions/messages.php');
					if($msgs[$_GET['message']]!=""){
						if($isError[$_GET['message']]=="1"){
							echo '<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<h4>Erreur!</h4>'.$msgs[$_GET['message']].'</div>';
						}else{
							echo '<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<h4>:)</h4>'.$msgs[$_GET['message']].'</div>';
						}
					}
				}
			}else{
				redirAccueil("42");
			}
			
		}else{
			redirAccueil($rep);
		}
		
		basPage();
	}else{
		redirAccueil("28");
	}
	
?>
