<?php
class Fichier{
	private $chemin;
	private $nom;
	private $id;
	
	public function __construct($chemin, $nom, $id){
		$this->chemin=$chemin;
		$this->nom=$nom;
		$this->id=$id;
	}
	
	public function getChemin(){
		return $this->chemin;
	}
	
	public function setChemin($chemin){
		$this->chemin=$chemin;
	}
	
	public function getNom(){
		return $this->nom;
	}
	
	public function setNom($nom){
		$this->nom=$nom;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id=$id;
	}
	
}

function fileAlreadyExist($file){
	include('InstallInfo.php');
	
	return file_exists($folderForFiles.$file);
}

function getFiles(){
	$bdd=new BddConnector();
	$sortie=null;
	
	$requete="SELECT idFic, nom, chemin FROM fichiers ;";
	
	try{
		$stmt = $bdd->getConnexion()->prepare($requete);
		$stmt->execute();
		while ($row=$stmt->fetch()){
			$sortie[]=new Fichier($row['chemin'],$row['nom'],$row['idFic']);
		}
		if(is_object($stmt)){$stmt->closeCursor();}
	}
	catch(PDOException $e){
		$bdd->deconnexion();
	}
	
	$bdd->deconnexion();
	
	return $sortie;
}

function addFile($name){
	include('InstallInfo.php');

	$bdd=new BddConnector();
	
	$path=$folderForFiles.$name;
	
	$requete="INSERT INTO fichiers (nom,chemin) VALUES (:name , :path )";
	try{
		$stmt = $bdd->getConnexion()->prepare($requete);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':path', $path, PDO::PARAM_STR);
		$stmt->execute();
		if(is_object($stmt)){$stmt->closeCursor();}
	}
	catch(PDOException $e){
		echo ($e);
		$bdd->deconnexion();
	}				
	$bdd->deconnexion();
	
	return $name;
}

function deleteFiles(){
	$bdd=new BddConnector();
	$retour=false;
	
	$requete="SELECT idFic, nom, chemin FROM fichiers ;";
	try{
		$stmt = $bdd->getConnexion()->prepare($requete);
		$stmt->execute();
		
		$haveToBeDeleted = array();
		
		while ($row=$stmt->fetch()){
			if(isset($_POST[$row['idFic']]) && $_POST[$row['idFic']]=="on"){
				//on supprime
				unlink($row['chemin']);
				$haveToBeDeleted[]=$row['idFic'];
			}
		}
		if(is_object($stmt)){$stmt->closeCursor();}
		
		foreach($haveToBeDeleted as $id){
			$requete2="DELETE FROM fichiers WHERE idFic=:idFic ;";
			$stmt2 = $bdd->getConnexion()->prepare($requete2);
			$stmt2->bindValue(':idFic', $id, PDO::PARAM_STR);
			$stmt2->execute();
			$retour=true;
		}
		if(is_object($stmt2)){$stmt2->closeCursor();}
	}
	catch(PDOException $e){
		$bdd->deconnexion();
	}
	$bdd->deconnexion();
	
	return $retour;
}
?>