<?php
	
	class BddConnector{
		private $host;
		private $database;
		private $user;
		private $password;
		private $connexion;
		private $typeDb;
		
		public function __construct(){
			include('InstallInfo.php');
			$this->host=$bddPlace;
			$this->database=$nomBDD;
			$this->user=$bddUser;
			$this->password=$bddMdp;
			if($typeDb!="mysql" && $typeDb!="sqlite"){
				throw new Exception('Type de base de données non reconnu');
			}else{
				$this->typeDb=$typeDb;
			}
		}
		  
		private function connexion() {
			try {
				if($this->typeDb=="mysql"){
					$this->connexion=new PDO('mysql:host='.$this->host.';dbname='.$this->database,$this->user,$this->password);
				}
				if($this->typeDb=="sqlite"){
					$this->connexion=new PDO('sqlite:'.$this->host);
				}
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
