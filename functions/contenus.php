<?php

/*******************************************************************************************************************************************/
/*******************************************utilisateur existant ?**************************************************************************/
/*******************************************************************************************************************************************/
	function isExist($login, $cryptedMDp){
		getBDD();
		
		$login=mysql_real_escape_string($login);
		$cryptedMDp=mysql_real_escape_string($cryptedMDp);
		
		$result=mysql_query('SELECT nom,mdp FROM users WHERE nom=\''.$login.'\' AND mdp=\''.$cryptedMDp.'\';') or die ('Erreur SQL isExist');

		if($row = mysql_fetch_array($result)){
			deco();
			return true;
		}else{
			deco();
			return false;
		}
	}

/*******************************************************************************************************************************************/
/******************************************Fichier menu*************************************************************************************/
/*******************************************************************************************************************************************/
	function createMenuFile(){
		include('InstallInfo');
		$ok=false;
		$sortie="";
	
		getBDD();
		$result=mysql_query("SELECT idLien, label FROM lien WHERE lienParent IS NULL ORDER BY idLien")or die ('Erreur SQL');
		
		$sortie=$sortie.' <div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<a class="brand" href="'.$localisationServeur.'"> @Charlie</a>
				<div class="container">
 
					<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					 </button>
					 
					<div class="nav-collapse collapse">
						<ul class="nav">';
		
		while ($donnees = mysql_fetch_array($result)){
			//pour chaque lien...
			/*$sortie=$sortie."\n<li>";
			
			$sortie=$sortie."\n<a href='index.php?page=".$donnees['idLien']."'>".$donnees['label']."</a>";*/
			
			$result2=mysql_query("SELECT idLien, label FROM lien WHERE lienParent='".$donnees['idLien']."'")or die ('Erreur SQL');
			
			if(mysql_num_rows($result2)>0){
				//il y a des sous liens du lien  <li class="divider"></li>
				$sortie=$sortie.'<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$donnees['label'].'<b class="caret"></b></a>
									<ul class="dropdown-menu">';
				while ($donnees2 = mysql_fetch_array($result2)){
					$sortie=$sortie."\n<li><a href='index.php?page=".$donnees2['idLien']."'>".$donnees2['label']."</a></li>";
				}
				$sortie=$sortie."\n</ul>
							</li>";
			}else{
				//il n'y a pas de sous-liens
				$sortie=$sortie."\n<li><a href='index.php?page=".$donnees['idLien']."'>".$donnees['label']."</a></li>";
			}
		}
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
		$monfichier = fopen('menu.php', 'w');
		fputs($monfichier, $sortie);
		fclose($monfichier);
		$ok=true;
		deco();
		
		return $ok;
	}

/*******************************************************************************************************************************************/
/*****************************************Gestion du contenu********************************************************************************/
/*******************************************************************************************************************************************/
	function recupContenuByID($idLien){
		$rep="";
		if(!is_numeric($idLien)){
			$rep="none";
		}else{
			getBDD();
			
			$idLien=mysql_real_escape_string($idLien);
			
			$result=mysql_query('SELECT label, tags, contenu FROM contenuPage,lien WHERE idLien=\''.$idLien.'\' AND contenuPage.idContenu=lien.idContenu') or die ('Erreur SQL');

			if( ! $data = mysql_fetch_array($result)){
				$data="none";
			}
		}
		deco();
		$data['contenu']=stripslashes($data['contenu']);
		return $data;
	}

	function getLabelParent(){
		$sortie="<select name='lienParent'>";
		getBDD();
		
		$result=mysql_query('SELECT idLien, label FROM lien WHERE lienParent IS NULL ORDER BY idLien') or die ('Erreur SQL');
		
		$sortie=$sortie."<option value='null'>Aucun</option>";
		
		while ($data = mysql_fetch_array($result)){
			$sortie=$sortie."<option value=".$data['idLien'].">".$data['label']."</option>";
		}
		
		$sortie=$sortie."</select>";
		deco();
		
		return $sortie;
	}
	
	function getLabels(){
		$sortie="<select name='liens'>";
		getBDD();
			
		$result=mysql_query('SELECT idLien, label FROM lien') or die ('Erreur SQL');
				
		while ($data = mysql_fetch_array($result)){
			$sortie=$sortie."<option value=".$data['idLien'].">".$data['label']."</option>";
		}
		
		$sortie=$sortie."</select>";
		deco();
		
		return $sortie;
	}
	
	function deleteContenu($idLien){
		getBDD();
		
		$idLien=mysql_real_escape_string($idLien);
		
		$result=mysql_query('SELECT idContenu FROM lien WHERE idLien=\''.$idLien.'\';') or die ('Erreur SQL');
				
		if($data = mysql_fetch_array($result)){
			$idContenu=$data['idContenu'];			
			mysql_query('DELETE FROM lien WHERE idLien=\''.$idLien.'\';') or die ('Erreur SQL');
			mysql_query('DELETE FROM contenuPage WHERE idContenu=\''.$idContenu.'\';') or die ('Erreur SQL');
			mysql_query('DELETE FROM contenuPage WHERE idContenu IN (SELECT idContenu FROM lien WHERE lienParent=\''.$idLien.'\')') or die ('Erreur SQL');
			mysql_query('DELETE FROM lien WHERE lienParent=\''.$idLien.'\'') or die ('Erreur SQL');
			deco();
			return "1";
		}else{
			deco();
			return "2";
		}
	}
	
	function insertContenu($labelLien,$lienParent,$tag,$contenu){
		
		getBDD();
		
		$labelLien=mysql_real_escape_string($labelLien);
		$contenu=str_replace("\n",'<br/>',$contenu);
		$contenu=mysql_real_escape_string($contenu);
					
		$result=mysql_query('SELECT label FROM lien WHERE label=\''.$labelLien.'\';')or die ('Erreur SQL');
		
		if(mysql_num_rows($result)>0){
			deco();
			return "3";
		}
		
		//pas de contenu?
		if($contenu==null || $contenu==""){
			deco();
			return "4";
		}
		//vérification que le lien parent existe et récupération de son id
		$idLienParent=0;
		if(!($lienParent==null || $lienParent=="" || $lienParent=="null")){
			$idLienParent=mysql_real_escape_string($lienParent);
		}
		
		//insertion du contenu
		mysql_query('INSERT INTO contenuPage (contenu) VALUES (\''.$contenu.'\')') or die ('Erreur SQL');
		//récupération de l'id du contenu
		
		$result=mysql_query('SELECT idContenu FROM contenuPage WHERE contenu=\''.$contenu.'\';') or die ('Erreur SQL');
		
		if($data = mysql_fetch_array($result))
			$id=$data['idContenu'];
		else{
			deco();
			return "5";
		}
			
		//insertion dans la table lien
		if($lienParent==null || $lienParent=="" || $lienParent=="null"){			
			mysql_query('INSERT INTO lien (label,idContenu,tags) VALUES (\''.$labelLien.'\',\''.$id.'\',\''.$tag.'\')') or die ('Erreur SQL');
		}else{			
			mysql_query('INSERT INTO lien (label,lienParent,idContenu,tags) VALUES (\''.$labelLien.'\',\''.$idLienParent.'\',\''.$id.'\',\''.$tag.'\')') or die ('Erreur SQL');
		}
		
		deco();
		return "6";
	}
	
	function changeContenu($idLien,$label,$tags,$contenu){
		//pas de contenu?
		if($contenu==null || $contenu==""){
			return "4";
		}
		
		getBDD();
	
		$idLien=mysql_real_escape_string($idLien);
		
		$contenu=str_replace("\n",'<br/>',$contenu);
		$contenu=mysql_real_escape_string($contenu);
		
		$result=mysql_query('SELECT idContenu FROM lien WHERE idLien=\''.$idLien.'\';') or die ('Erreur SQL');
				
		if($data = mysql_fetch_array($result))
			$id=$data['idContenu'];
		else{
			deco();
			return "7";
		}
						
		//insertion dans la table du nouveau contenu
		$sql='UPDATE contenuPage, lien SET contenuPage.contenu=\''.$contenu.'\', lien.label=\''.$label.'\', lien.tags=\''.$tags.'\' WHERE contenuPage.idContenu=\''.$id.'\' AND contenuPage.idContenu=lien.idContenu;';
		mysql_query($sql) or die ('Erreur SQL : '.$sql);
		deco();
		
		return "8";
	}

/*******************************************************************************************************************************************/
/**************************************Gestion des fichiers sur le serveur******************************************************************/
/*******************************************************************************************************************************************/
	function affiFiles(){
		getBDD();
		
		$result=mysql_query('SELECT idFic, nom, chemin FROM fichiers') or die ('Erreur SQL');
				
		while ($data = mysql_fetch_array($result)){
			echo '<tr><td><a href="'.$data['chemin'].'">'.$data['nom'].'</a></td><td><input type="checkbox" name="'.$data['idFic'].'" id="'.$data['idFic'].'" /></td></tr>';
		}
		
		deco();
	}
	
	function addFile($name,$dossier){
		getBDD();
		
		$name=mysql_real_escape_string($name);
		$dossier=mysql_real_escape_string($dossier);
		$path=$dossier."/".$name;
		
		mysql_query('INSERT INTO fichiers (nom,chemin) VALUES (\''.$name.'\',\''.$path.'\')') or die ('Erreur SQL');
				
		deco();
		
		return $name;
	}
	
	function deleteFiles($_POST){
		getBDD();
		$retour=false;
		
		$result=mysql_query('SELECT idFic, nom, chemin FROM fichiers') or die ('Erreur SQL');
				
		while ($data = mysql_fetch_array($result)){
			//echo '<tr><td><a href="'.$data['chemin'].'">'.$data['nom'].'</a></td><td><input type="checkbox" name="'.$data['idFic'].'" id="'.$data['idFic'].'" /></td></tr>';
			if(isset($_POST[$data['idFic']]) && $_POST[$data['idFic']]=="on"){
				//on supprime
				unlink($data['chemin']);
				mysql_query('DELETE FROM fichiers WHERE idFic=\''.$data['idFic'].'\'') or die ('Erreur SQL');
				$retour=true;
			}
		}
		return $retour;
	}
?>
