<?php
	session_start();
	include("functions.php");
	
	
	if(isset($_GET['art']) && is_numeric($_GET['art'])){
		
		$article=new Article();
		$rep=$article->getArticleById($_GET['art']);
		if($rep==""){
			
			include('functions/InstallInfo.php');
			enTete($article->getTags(),$siteName." - ".$article->getTitre());
			
			//affichage de l'article
			echo '<div class="page-header"><h1>'.$article->getTitre().'</h1></div><br/>';
			echo '<div class="well">';
			echo '<p class="pull-right"><i class="icon-calendar"></i> '.$article->getDate().'</p><br/><br/>';
			echo $article->getContenu();
			echo '<br/><br/><p class="pull-right"><i class="icon-tags"></i> '.$article->getTags().'</p><br/>';
			echo'</div><br/><section id="com"><br/>';
			
			//affichage des commentaires
			if($commActifs){
				$commentaires=$article->getCommentaires();
				$isAdmin=false;
				if(isset($_SESSION['userName']) && isset($_SESSION['pwd']) && isExist($_SESSION['userName'],$_SESSION['pwd'])){
					$isAdmin=true;
				}
				foreach($commentaires as $commentaire){
					echo '<div class="row"><div class="span1"></div>';
					echo '<div class="span10"><div class="well well-small">';
					
					echo '<i class="icon-user"></i> <small>'.$commentaire->getCommentateur().'</small>';
					echo '<p class="pull-right"><i class="icon-calendar"></i> <small>'.$commentaire->getDateComm().'</small></p><br/>';
					echo $commentaire->getCommentaire();
					if($isAdmin){
						//C'est un admin ?
						echo '<p class="pull-right"><small><a href="deleteComm.php?com='.$commentaire->getIdCommentaire().'&art='.$_GET['art'].'">Supprimer</a></small></p>';
					}
					
					echo '</div></div>';
					echo '<div class="span1"></div></div></section>
						';
				}
				
				echo '</section>';
				
				//partie insertion de commentaire
				echo '<section id="addCom"><br/><div class="row"><div class="span2"></div>';
				echo '<div class="span8"><div class="well well-small">';
				echo '<i class="icon-comment"></i> <small>Ajouter un commentaire</small>';
				
				echo '<form class="form-horizontal" method="post" action="addComment.php?art='.$_GET['art'].'">';
				echo '<div class="control-group">
						<label class="control-label" for="commentateur">Votre nom :</label>
						<div class="controls">
							<input type="text" name="commentateur" id="commentateur" placeholder="Votre nom" value="';
				//si il y a un nom en session on prends
				if(isset($_SESSION['nomCommentateur'])){
					echo $_SESSION['nomCommentateur'];
				}
				echo		'">
						</div>
					</div>';
							
				echo '<div class="control-group">
						<label class="control-label" for="commentaire">Votre commentaire :</label>
						<div class="controls">
							<textarea name="commentaire" id="commentaire" placeholder="Votre commentaire" rows="3" class="span6">';
				//si il y a un commentaire en session on prends		
				if(isset($_SESSION['commentaire'])){
					echo $_SESSION['commentaire'];
				}
				echo		'</textarea>
						</div>
					</div>';
				
				//reCaptcha
				require_once('libraries/recaptchalib.php');
				include('functions/InstallInfo.php');
				
				$error = null;
				echo '<div class="control-group">
						<label class="control-label" for=""></label>
						<div class="controls">
							'.recaptcha_get_html($publicKeyReCaptcha, $error).'
						</div>
					</div>';
					
				echo '<br/><div class="control-group">
						<div class="controls">
							<button type="submit" class="btn">Envoyer !</button>
						</div>
					</div>';
				echo '</form>';
				
				echo '</div></div>';			
				echo '<div class="span2"></div></div></section>';
				
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
						echo '<div class="alert alert-error">
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
			redirAccueil($rep);
		}
		
		basPage();
	}else{
		redirAccueil("28");
	}
	
?>
