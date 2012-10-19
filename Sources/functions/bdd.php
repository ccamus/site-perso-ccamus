<?php
	// function getBDD(){
		// include('InstallInfo.php');
		// mysql_connect($bddPlace, $bddUser, $bddMdp) or die("Erreur de connection");
		// mysql_select_db($nomBDD) or die ("Erreur de connection à la base de données");
	// }
	
	// function deco(){
		// mysql_close();
	// }
	
	class BddConnector{
		private $host;
		private $database;
		private $user;
		private $password;
		private $connexion;
		
		public function __construct(){
			include('InstallInfo.php');
			$this->host=$bddPlace;
			$this->database=$nomBDD;
			$this->user=$bddUser;
			$this->password=$bddMdp;
		}
		  
		private function connexion() {
			try {
				$this->connexion=new PDO('mysql:host='.$this->host.';dbname='.$this->database,$this->user,$this->password);
				$this->connexion->setattribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $e)
			{
				echo "La base de donnees est deconnectee. Veuillez reessayer de charger la page.";
			}
		}
		
		public function getConnexion(){
			if($this->connexion==null){
				$this->connexion();
			}
			return $this->connexion;
		}

		//Fonction pour la déconnexion
		public function deconnexion() {
			$this->connexion=null;
		}
	}
	
?>
