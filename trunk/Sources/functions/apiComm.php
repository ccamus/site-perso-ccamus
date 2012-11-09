<?php
	
	function tweet($text){
		$retour=false;

		include('libraries/tmhOAuth.php');
		include('InstallInfo.php');
		
		$tmhOAuth = new tmhOAuth(array(
			'consumer_key' => $consumer_key,
			'consumer_secret' => $consumer_secret,
			'user_token' => $user_token,
			'user_secret' => $user_secret,
		));
	 
		$tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
			'status' => utf8_encode($text)
		));
		
		if ($tmhOAuth->response['code'] == 200) {
			$retour=true;
		}
		
		return $retour;
	}
	
?>
