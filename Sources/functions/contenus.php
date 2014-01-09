<?php

/*******************************************************************************************************************************************/
/*******************************************utilisateur existant ?**************************************************************************/
/*******************************************************************************************************************************************/
	function isExist($login, $cryptedMDp){
		$retour=false;
		
		$bdd=new BddConnector();
		//Récupération de l'id contenu
		$requete="SELECT nom,mdp FROM users WHERE nom=:nom AND mdp=:mdp;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':nom', $login, PDO::PARAM_STR);
			$stmt->bindValue(':mdp', $cryptedMDp, PDO::PARAM_STR);
			$stmt->execute(); 	
			$row=$stmt->fetch();	
			if(is_object($stmt)){$stmt->closeCursor();}
			if(isset($row['nom'])){
				$retour=true;
			}			
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		$bdd->deconnexion();
		
		return $retour;
	}
	
	function userExist($userName){
		$retour=false;
		
		$bdd=new BddConnector();
		//Récupération de l'id contenu
		$requete="SELECT nom FROM users WHERE nom=:nom;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':nom', $userName, PDO::PARAM_STR);
			$stmt->execute();
			
			if($row=$stmt->fetch()){
				$retour=true;
			}
			if(is_object($stmt)){$stmt->closeCursor();}			
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		$bdd->deconnexion();
		
		return $retour;
	}

/*******************************************************************************************************************************************/
/******************************************Fichier menu*************************************************************************************/
/*******************************************************************************************************************************************/
	function createMenuFile(){
		include('InstallInfo.php');
		$ok="17";
		$sortie="";
	
		$bdd=new BddConnector();
		$requete="SELECT idLien, label FROM lien WHERE lienParent IS NULL ORDER BY idLien";
		try{
			$sortie=$sortie.' <div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<a class="brand" href="'.$localisationServeur.'">@Charlie</a>
					<div class="container">
	 
						<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
						<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						 </button>
						 
						<div class="nav-collapse collapse">
							<ul class="nav">';
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->execute(); 	
			while ($row=$stmt->fetch()){
				//pour chaque lien...
				
				$requete2="SELECT idLien, label FROM lien WHERE lienParent=:lienParent";
				$stmt2 = $bdd->getConnexion()->prepare($requete2);
				$stmt2->bindValue(':lienParent', $row['idLien'], PDO::PARAM_STR);
				$stmt2->execute(); 	
				
				if($row2=$stmt2->fetch()){
					//il y a des sous liens du lien  <li class="divider"></li>
					$sortie=$sortie.'<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$row['label'].'<b class="caret"></b></a>
										<ul class="dropdown-menu">';
					do{
						$sortie=$sortie."\n<li><a href='index.php?page=".$row2['idLien']."'>".$row2['label']."</a></li>";
					}while($row2=$stmt2->fetch());
					$sortie=$sortie."\n</ul>
								</li>";
				}else{
					//il n'y a pas de sous-liens
					$sortie=$sortie."\n<li><a href='index.php?page=".$row['idLien']."'>".$row['label']."</a></li>";
				}
				if(is_object($stmt2)){$stmt2->closeCursor();}
			}			
			if(is_object($stmt)){$stmt->closeCursor();}
			
			$bdd->deconnexion();

			//insertion du menu administrateur
			$sortie=$sortie."\n<li>";				
			$sortie=$sortie."\n<a href='adminInterface.php'>Administration</a>";
			$sortie=$sortie."\n</li>";
					
			$sortie=$sortie."</ul>
						</div>
					</div>
				</div>
			</div>";
			//écriture dans le fichier
			
			
		
			$monfichier = fopen('generated/menu.php', 'w');
			fputs($monfichier, $sortie);
			fclose($monfichier);
			$ok="18";
			
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		return $ok;
	}

/*******************************************************************************************************************************************/
/*****************************************Gestion du contenu********************************************************************************/
/*******************************************************************************************************************************************/
	function recupContenuByID($idLien){
		$rep="";
		try{
			if(!is_numeric($idLien)){
				$rep="none";
			}else{
				$bdd=new BddConnector();
				
				$requete="SELECT label, tags, contenu FROM contenuPage,lien WHERE idLien=:idLien AND contenuPage.idContenu=lien.idContenu";
				
				$stmt = $bdd->getConnexion()->prepare($requete);
				$stmt->bindValue(':idLien', $idLien, PDO::PARAM_STR);
				$stmt->execute(); 	
								
				if($row=$stmt->fetch()){
					$rep=$row;
				}else{
					$rep="none";
				}
				if(is_object($stmt)){$stmt->closeCursor();}
			}
			$bdd->deconnexion();	
		}
		catch(PDOException $e){
			$rep="none";
			$bdd->deconnexion();
		}
		$rep['contenu']=stripslashes($rep['contenu']);
		return $rep;
	}

	function getLabelParent(){
		$sortie="<select name='lienParent'>";
		$bdd=new BddConnector();
		
		$requete="SELECT idLien, label FROM lien WHERE lienParent IS NULL ORDER BY idLien";
		try{
			$sortie=$sortie."<option value='null'>Aucun</option>";
			
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->execute(); 	
			while ($row=$stmt->fetch()){
				$sortie=$sortie."<option value=".$row['idLien'].">".$row['label']."</option>";
			}
			if(is_object($stmt)){$stmt->closeCursor();}
			$sortie=$sortie."</select>";
			$bdd->deconnexion();		
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		return $sortie;
	}
	
	function getLabels(){
		$sortie="<select name='liens'>";
		$bdd=new BddConnector();
			
		$requete="SELECT idLien, label FROM lien";
		try{	
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->execute(); 
			
			while ($row=$stmt->fetch()){
				$sortie=$sortie."<option value=".$row['idLien'].">".$row['label']."</option>";
			}
			if(is_object($stmt)){$stmt->closeCursor();}
			$sortie=$sortie."</select>";
			
			$bdd->deconnexion();
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}		
		
		return $sortie;
	}
	
	function deleteContenu($idLien){
		$bdd=new BddConnector();
		$retour="2";
		
		try{	
		
			$requete="SELECT idContenu FROM lien WHERE idLien=:idLien ;";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':idLien', $idLien, PDO::PARAM_STR);
			$stmt->execute(); 
					
			if($row=$stmt->fetch()){
				$idContenu=$row['idContenu'];
				
				if(is_object($stmt)){$stmt->closeCursor();}
				
				$requete2="DELETE FROM lien WHERE idLien=:idLien ;";
				$requete3="DELETE FROM contenuPage WHERE idContenu=:idContenu ;";
				$requete4="DELETE FROM contenuPage WHERE idContenu IN (SELECT idContenu FROM lien WHERE lienParent=:idLien) ;";
				$requete5="DELETE FROM lien WHERE lienParent=:idContenu ;";
				
				
				$stmt2 = $bdd->getConnexion()->prepare($requete2);
				$stmt3 = $bdd->getConnexion()->prepare($requete3);
				$stmt4 = $bdd->getConnexion()->prepare($requete4);
				$stmt5 = $bdd->getConnexion()->prepare($requete5);
				
				$stmt2->bindValue(':idLien', $idLien, PDO::PARAM_STR);
				$stmt3->bindValue(':idContenu', $idContenu, PDO::PARAM_STR);
				$stmt4->bindValue(':idLien', $idLien, PDO::PARAM_STR);
				$stmt5->bindValue(':idContenu', $idContenu, PDO::PARAM_STR);
				
				
				$stmt2->execute();
				if(is_object($stmt2)){$stmt2->closeCursor();}
				$stmt3->execute();
				if(is_object($stmt3)){$stmt3->closeCursor();}
				$stmt4->execute();
				if(is_object($stmt4)){$stmt4->closeCursor();}
				$stmt5->execute();
				if(is_object($stmt5)){$stmt5->closeCursor();}
				
				$retour="1";
			}
			
			$bdd->deconnexion();
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}	
		
		return $retour;
	}
	
	function insertContenu($labelLien,$lienParent,$tag,$contenu){
		$rep="6";
		$bdd=new BddConnector();
		
		$contenu=str_replace("\n",'<br/>',$contenu);
		
		try{
			$requete="SELECT label FROM lien WHERE label=:labelLien ;";
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':labelLien', $labelLien, PDO::PARAM_STR);
			$stmt->execute();
			
			if($row=$stmt->fetch()){
				$rep="3";
			}else{
				if(is_object($stmt)){$stmt->closeCursor();}
				//pas de contenu?
				if((!isset($contenu)) || $contenu==""){
					$rep="4";
				}else{
					if((!($lienParent==null || $lienParent=="" || $lienParent=="null")) && !is_numeric(lienParent)){
                        //le lien parent n'est pas un nombre
						$rep="4";
					}else{
						//insertion du contenu
						$requete2="INSERT INTO contenuPage (contenu) VALUES (:contenu);";
						$stmt2 = $bdd->getConnexion()->prepare($requete2);
						$stmt2->bindValue(':contenu', $contenu, PDO::PARAM_STR);
						$stmt2->execute();
						if(is_object($stmt2)){$stmt2->closeCursor();}
						
						//récupération de l'id du contenu					
						$requete3="SELECT idContenu FROM contenuPage WHERE contenu=:contenu ;";
						$stmt3 = $bdd->getConnexion()->prepare($requete3);
						$stmt3->bindValue(':contenu', $contenu, PDO::PARAM_STR);
						$stmt3->execute();
						
						if($row3=$stmt3->fetch()){
							$id=$row3['idContenu'];
							if(is_object($stmt3)){$stmt3->closeCursor();}
							
							//insertion dans la table lien
							if($lienParent==null || $lienParent=="" || $lienParent=="null"){			
								$requete4="INSERT INTO lien (label,idContenu,tags) VALUES (:labelLien , :id , :tags ) ;";
								$stmt4 = $bdd->getConnexion()->prepare($requete4);
							}else{			
								$requete4="INSERT INTO lien (label,lienParent,idContenu,tags) VALUES (:labelLien , :lienParent , :id , :tags ) ;";
								$stmt4 = $bdd->getConnexion()->prepare($requete4);
								$stmt4->bindValue(':lienParent', $idLienParent, PDO::PARAM_STR);
							}
							$stmt4->bindValue(':labelLien', $labelLien, PDO::PARAM_STR);
							$stmt4->bindValue(':id', $id, PDO::PARAM_STR);
							$stmt4->bindValue(':tags', $tag, PDO::PARAM_STR);
							$stmt4->execute();
							
							if(is_object($stmt4)){$stmt4->closeCursor();}
						}else{
							$rep="5";echo "la";
						}
					}
				}
			}
			$bdd->deconnexion();
		}
		catch(PDOException $e){
			$bdd->deconnexion();echo $e->getMessage();
			$rep="5";
		}
		return $rep;
	}
	
	function changeContenu($idLien,$label,$tags,$contenu){
		$rep="8";
	
		//pas de contenu?
		if($contenu==null || $contenu==""){
			$rep="4";
		}else{
		
			$bdd=new BddConnector();
			try{							
				$contenu=str_replace("\n",'<br/>',$contenu);
				
				$requete="SELECT idContenu FROM lien WHERE idLien=:idLien ;";
				$stmt = $bdd->getConnexion()->prepare($requete);
				$stmt->bindValue(':idLien', $idLien, PDO::PARAM_STR);
				$stmt->execute();
						
				if($row=$stmt->fetch()){
					$id=$row['idContenu'];
					if(is_object($stmt)){$stmt->closeCursor();}
					//insertion dans la table du nouveau contenu
					$requete2="UPDATE lien SET label=:label, tags=:tags WHERE idLien=:idLien ;";
					$stmt2 = $bdd->getConnexion()->prepare($requete2);
					
					$stmt2->bindValue(':label', $label, PDO::PARAM_STR);
					$stmt2->bindValue(':tags', $tags, PDO::PARAM_STR);
					$stmt2->bindValue(':idLien', $idLien, PDO::PARAM_STR);
					
					$stmt2->execute();
					if(is_object($stmt2)){$stmt2->closeCursor();}
					
					$requete3="UPDATE contenuPage SET contenu=:contenu WHERE idContenu=:id ;";
					$stmt3 = $bdd->getConnexion()->prepare($requete3);
					
					$stmt3->bindValue(':contenu', $contenu, PDO::PARAM_STR);
					$stmt3->bindValue(':id', $id, PDO::PARAM_STR);
					
					$stmt3->execute();
					if(is_object($stmt3)){$stmt3->closeCursor();}
				}else{
					$rep="7";
				}
				$bdd->deconnexion();
			}
			catch(PDOException $e){
				$bdd->deconnexion();
				$rep="26";
			}
		}
		
		return $rep;
	}

/*******************************************************************************************************************************************/
/**************************************Gestion des fichiers sur le serveur******************************************************************/
/*******************************************************************************************************************************************/
	function fileAlreadyExist($file){
		include('InstallInfo.php');
		
		return file_exists($folderForFiles.$file);
	}

	function affiFiles(){
		$bdd=new BddConnector();
		$sortie="";
		
		$requete="SELECT idFic, nom, chemin FROM fichiers ;";
		
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->execute();
			while ($row=$stmt->fetch()){
				$sortie=$sortie.'<tr><td><a href="'.$row['chemin'].'">'.$row['nom'].'</a></td><td><input type="checkbox" name="'.$row['idFic'].'" id="'.$row['idFic'].'" /></td></tr>';
			}
			if(is_object($stmt)){$stmt->closeCursor();}
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		
		$bdd->deconnexion();
		
		return $sortie;
	}
	
	function addFile($name){
		include('InstallInfo.php');
	
		$bdd=new BddConnector();
		
		$path=$folderForFiles.$name;
		
		$requete="INSERT INTO fichiers (nom,chemin) VALUES (:name , :path )";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->bindValue(':path', $path, PDO::PARAM_STR);
			$stmt->execute();
			if(is_object($stmt)){$stmt->closeCursor();}
		}
		catch(PDOException $e){
			echo ($e);
			$bdd->deconnexion();
		}				
		$bdd->deconnexion();
		
		return $name;
	}
	
	function deleteFiles(){
		$bdd=new BddConnector();
		$retour=false;
		
		$requete="SELECT idFic, nom, chemin FROM fichiers ;";
		try{
			$stmt = $bdd->getConnexion()->prepare($requete);
			$stmt->execute();
			
			$haveToBeDeleted = array();
			
			while ($row=$stmt->fetch()){
				if(isset($_POST[$row['idFic']]) && $_POST[$row['idFic']]=="on"){
					//on supprime
					unlink($row['chemin']);
					$haveToBeDeleted[]=$row['idFic'];
				}
			}
			if(is_object($stmt)){$stmt->closeCursor();}
			
			foreach($haveToBeDeleted as $id){
				$requete2="DELETE FROM fichiers WHERE idFic=:idFic ;";
				$stmt2 = $bdd->getConnexion()->prepare($requete2);
				$stmt2->bindValue(':idFic', $id, PDO::PARAM_STR);
				$stmt2->execute();
				$retour=true;
			}
			if(is_object($stmt2)){$stmt2->closeCursor();}
		}
		catch(PDOException $e){
			$bdd->deconnexion();
		}
		$bdd->deconnexion();
		
		return $retour;
	}
?>
