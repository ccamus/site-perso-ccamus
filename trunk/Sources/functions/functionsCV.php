<?php
	
	/**
	 * Récupère le contenu d'un CV
	 * 1 : cv long
	 * 2 : cv court
	 * 3 : cv anglais
	 */
	function getContenuCV($cv){
		$retour = "";
		switch ($cv) {
			case 1:
				$retour = readGeneratedFile("CV/cvLong.html");
				break;
			case 2:
				$retour = readGeneratedFile("CV/cvCourt.html");
				break;
			case 3:
				$retour = readGeneratedFile("CV/cvAnglais.html");
				break;
		}
		return $retour;
	}
	
	/**
	 * Ecrit le contenu d'un CV
	 * 1 : cv long
	 * 2 : cv court
	 * 3 : cv anglais
	 */
	function writeContenuCV($cv, $contenu){
		$retour = false;
		switch ($cv) {
			case 1:
				$retour = writeGeneratedFile("CV/cvLong.html", $contenu);
				break;
			case 2:
				$retour = writeGeneratedFile("CV/cvCourt.html", $contenu);
				break;
			case 3:
				$retour = writeGeneratedFile("CV/cvAnglais.html", $contenu);
				break;
		}
		return $retour;
	}

?>