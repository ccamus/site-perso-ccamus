<?php

	/*
	 * Nom du site tel qu'il va apparaitre sur l'interface
	 */
	$siteName='@Charlie';

	/*
	 * Endroit où est située la base de donnée
	 * En dev : localhost
	 * En Prod : camus.charlie.sql.free.fr
	 */
	//$bddPlace='localhost';
	$bddPlace='/home/pi/www/sqlite/test.sqlite3';
	
	//utilisateur de la base de données
	$bddUser='camus.charlie';
	
	//mot de passe de l'utilisateur
	$bddMdp='camus.charlie';
	
	//nom de la base de données
	$nomBDD='camus_charlie';
	
	/*
	 * type de base de données
	 * Types reconnus : mysql sqlite
	 */
	$typeDb='sqlite';
	
	/*
	 * Endroit où est localisé la page d'accueil.
	 * En dev : http://192.168.0.10/Site_DEV
	 * En prod : http://camus.charlie.free.fr
	 */
	$localisationServeur='http://rasbi.hd.free.fr/trunk/Sources';
	
	/*
	 * Endroit où sont stockés les fichiers chargés sur le site
	 * Par défaut : donnes
	 */
	$folderForFiles="donnes/";
	
	
	/*
	 * Clé publique et privé pour captcha
	 */
	$publicKeyReCaptcha="6Lcbw9gSAAAAAFKloYXuUVDV4zSc0My0ZqkWXnaa";
	$privateKeyReCaptcha="6Lcbw9gSAAAAAN0y8vS2KjCWMxceMt2mwsR4xp76";
	
	/*
	 * Données relatives à la connexion avec l'API tweeter
	 */
	$consumer_key="";
	$consumer_secret="";
	$user_token="";
	$user_secret="";
	
	/*
	 *Activer ou non les commentaires
	 */
	$commActifs=true;
	
?>
