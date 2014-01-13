<?php
	include("functions/bdd.php");
	include('functions/other.php');
	include('functions/contenus.php');
	include('functions/commentaire.php');
	session_start();
	
	if(isset($_GET['art']) && $_GET['art']!="" && is_numeric($_GET['art'])){
		if(isset($_POST['commentateur']) &&
			isset($_POST['commentaire']) ){
			//il est bien passé par le formulaire d'ajout de comms
			
			if($_POST['commentateur']=="" || $_POST['commentaire']==""){
				//il a rien renseigné !
				$_SESSION['nomCommentateur']=$_POST['commentateur'];
				$_SESSION['commentaire']=$_POST['commentaire'];
				redirVisuArticle($_GET['art'],"36");
			}else{
			
				include('functions/InstallInfo.php');
				
				if(userExist($_POST['commentateur']) &&
					(!(isset($_SESSION['userName']) && isset($_SESSION['pwd'])) ||
					!isExist($_SESSION['userName'],$_SESSION['pwd']) ||
					$_SESSION['userName']!=$_POST['commentateur'])){
						//Falsification d'identité !!!
						$_SESSION['nomCommentateur']=$_POST['commentateur'];
						$_SESSION['commentaire']=$_POST['commentaire'];
						redirVisuArticle($_GET['art'],"35");				
				}else{
					
						/*
						 * L'article sur lequel il poste a pour idArticle un chiffre
						 * Captcha passé
						 * Il ne falsifie pas le nom d'un admin
						 * Tous les champs sont remplis
						 */
						$commentaire=new Commentaire();
						$commentaire->setDateComm(date("Y-m-d H:i:s"));
						$commentaire->setCommentateur($_POST['commentateur']);
						$commentaire->setCommentaire($_POST['commentaire']);
						$commentaire->setIdArticle($_GET['art']);
						$rep=$commentaire->add();
						if($rep!="33"){
							$_SESSION['nomCommentateur']=$_POST['commentateur'];
							$_SESSION['commentaire']=$_POST['commentaire'];
						}
						redirVisuArticle($_GET['art'],$rep);								
				}
			}
		}else{
			//erreur de récupération du formulaire
			redirVisuArticle($_GET['art'],"10");
		}
	}else{
		//l'article n'existe pas
		redirAccueil("34");
	}
?>
