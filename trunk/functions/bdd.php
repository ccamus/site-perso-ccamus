<?php
	function getBDD(){
		include('InstallInfo.php');
		mysql_connect($bddPlace, $bddUser, $bddMdp) or die("Erreur de connection");
		mysql_select_db($nomBDD) or die ("Erreur de connection à la base de données");
	}
	
	function deco(){
		mysql_close();
	}
?>
