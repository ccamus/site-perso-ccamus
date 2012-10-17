<?php
	function getCss(){
		$css="";
		
		$monfichier = fopen('stylePerso.css', 'r');
		while (!feof($monfichier)) { //on parcourt toutes les lignes
			$css .= fgets($monfichier, 4096); // lecture du contenu de la ligne
		}
		fclose($monfichier);
		
		return $css;
	}
	
	function setCss($css){
		$ok=false;
		
		$monfichier = fopen('stylePerso.css', 'w');
		fputs($monfichier, $css);
		fclose($monfichier);
		$ok=true;
		
		return $ok;
	}
	
	function redirAccueil($message){
		include('messages.php');
		include('InstallInfo.php');
		if($msgs[$message]!=''){
			header('Location: '.$localisationServeur.'?message='.$message);
		}else{
			header('Location: '.$localisationServeur);
		}
	}
?>
