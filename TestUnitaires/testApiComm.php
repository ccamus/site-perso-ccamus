<?php

/*******************************************************************************************************************************************/
/********************Tests de la communication avec les apis********************************************************************************/
/*******************************************************************************************************************************************/
	$rep=testAPI();
	if($rep==1){
		echo "<br/><h1>ERROR</h1>";
	}else{
		echo "<br/><h1>OK</h1>";
	}

	function testAPI(){
		echo "<h1>Test de la communication avec les apis</h1><br/>";
		
		echo "1 - include des fonctions<br/>";
		include('../Sources/functions.php');
		
		echo "2 - tweet<br/>";
		$rep=tweet("Bientôt en ligne une nouvelle version du site http://camus.charlie.free.fr");
		if(!$rep){
			return 1;
		}
		
		return 0;
	}
	

?>
