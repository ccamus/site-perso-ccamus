<?php
/*******************************************************************************************************************************************/
/********************Tests de login*********************************************************************************************************/
/*******************************************************************************************************************************************/

	$rep=testLogin();
	if($rep=="1"){
		echo "<br/><h1>ERROR</h1>";
	}else{
		echo "<br/><h1>OK</h1>";
	}
	
	function testLogin(){
		echo "<h1>Test de la classe Article</h1><br/>";
	
		echo "1 - include des fonctions<br/>";
		include('../Sources/functions.php');
		include('../Sources/functions/messages.php');

		$login="charlie";
		$mdp="blop";
		
		echo "2 - Appel de la fonction<br/>";
		if(isExist($login,md5($mdp))){
			echo "exist";
		}else{
			echo "noExist";
		}
	}
	
?>
