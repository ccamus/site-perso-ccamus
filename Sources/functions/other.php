<?php
	function getCss(){
		return readGeneratedFile('generated/stylePerso.css');
	}
	
	function setCss($css){
		return writeGeneratedFile('generated/stylePerso.css',$css);
	}
	
	function getHeadAccueil(){
		return readGeneratedFile('generated/headAccueil.html');
	}
	
	function setHeadAccueil($text){
		return writeGeneratedFile('generated/headAccueil.html',$text);
	}
	
	function readGeneratedFile($file){
		$retour="";
		
		$monfichier = fopen($file, 'r');
		while (!feof($monfichier)) { //on parcourt toutes les lignes
			$retour .= fgets($monfichier, 4096); // lecture du contenu de la ligne
		}
		fclose($monfichier);
		
		return $retour;
	}
	
	function writeGeneratedFile($file,$text){
		$ok=false;
		
		$monfichier = fopen($file, 'w');
		fputs($monfichier, $text);
		fclose($monfichier);
		$ok=true;
		
		return $ok;
	}
	
	function redirAccueil($message){
		include('messages.php');
		include('InstallInfo.php');
		if($msgs[$message]!=''){
			header('Location: '.$localisationServeur.'/index.php?message='.$message);
		}else{
			header('Location: '.$localisationServeur.'/index.php');
		}
	}
	
	function redirVisuArticle($idArticle,$message){
		include('messages.php');
		include('InstallInfo.php');
		if($msgs[$message]!=''){
			header('Location: '.$localisationServeur.'/visuArticle.php?message='.$message.'&art='.$idArticle);
		}else{
			header('Location: '.$localisationServeur.'/visuArticle.php');
		}
	}
?>
