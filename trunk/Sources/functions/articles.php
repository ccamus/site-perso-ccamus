<?php

/*******************************************************************************************************************************************/
/*******************************************Définition de la classe Article*****************************************************************/
/*******************************************************************************************************************************************/
class Article{
	private $idArticle;
	private $date;
	private $contenu;
	private $titre;
	private $tags;
	private $commentaires;
	
	//Récupère un article selon son id
	public function getArticleById($id){
		
		$rep="";
		if(!is_numeric($id)){
			$rep="24";
		}else{
			$bdd=new BddConnector();
			
			$requete="SELECT date, contenu, titre, tags FROM contenuPage, article WHERE idArticle=\':idArt\' AND contenuPage.idContenu=article.idContenu ;";
			
			try{
				$stmt = $bdd->getConnexion()->prepare($requete);
				$stmt->bindValue(':idArt', $id, PDO::PARAM_STR);
				$stmt->execute(); 
				$row=$stmt->fetch();
				$bdd->deconnexion();
				
				if(!isset($row['contenu'])){
					$rep="24";
				}else{
					$this->idArticle=$id;
					$this->date=$row['date'];
					$this->contenu=stripslashes($row['contenu']);
					$this->titre=$row['titre'];
					$this->tags=$row['tags'];
				}				
			}
			catch(PDOException $e){
				$bdd->deconnexion();
				$rep="26";
			}
		}
		
		deco();		
		
		return $rep;
	}
	
	//Enregistre un article en base
	public function add(){
		
		$titre=mysql_real_escape_string($this->titre);
		echo $this->contenu.'laaaaaaaaaa<br/>';
		$contenu=str_replace("\n",'<br/>',$this->contenu);
		echo $contenu.'laaaaaaaaaa<br/>';
		$contenu=mysql_real_escape_string($contenu);
		echo $contenu.'laaaaaaaaaa<br/>';
		$tags=mysql_real_escape_string($this->tags);
					
		//pas de contenu?
		if($contenu==null || $contenu==""){
			return "4";
		}
		
		getBDD();
		//insertion du contenu
		mysql_query('INSERT INTO contenuPage (contenu) VALUES (\''.$contenu.'\')') or die ('Erreur SQL');
		
		//récupération de l'id du contenu		
		$result=mysql_query('SELECT idContenu FROM contenuPage WHERE contenu=\''.$contenu.'\';') or die ('Erreur SQL');
		
		if($data = mysql_fetch_array($result))
			$id=$data['idContenu'];
		else{
			deco();
			return "5";
		}
			
		//insertion dans la table article		
		mysql_query('INSERT INTO article (dateArticle,titre,tags,idContenu) VALUES (\''.$this->date.'\',\''.$titre.'\',\''.$tags.'\',\''.$id.'\')') or die ('Erreur SQL');
		
		//récupération de l'id du contenu		
		$result=mysql_query('SELECT idArticle FROM article WHERE idContenu=\''.$id.'\';') or die ('Erreur SQL');
		
		if($data = mysql_fetch_array($result))
			$this->idArticle=$data['idArticle'];
		else{
			deco();
			return "5";
		}
		
		deco();
		return "6";
	}
	
	function delete(){
		$rep="";
		getBDD();
		
		$result=mysql_query('SELECT idContenu FROM article WHERE idArticle=\''.$this->idArticle.'\';') or die ('Erreur SQL');
				
		if($data = mysql_fetch_array($result)){
			$idContenu=$data['idContenu'];			
			mysql_query('DELETE FROM article WHERE idArticle=\''.$this->idArticle.'\';') or die ('Erreur SQL');
			mysql_query('DELETE FROM contenuPage WHERE idContenu=\''.$idContenu.'\';') or die ('Erreur SQL');
			$rep="1";
		}else{
			$rep="25";
		}
		deco();
		return $rep;
	}
	
	function modify(){
		//pas de contenu?
		if($this->contenu==null || $this->contenu==""){
			return "4";
		}
		
		getBDD();
	
		$titre=mysql_real_escape_string($this->titre);
		$contenu=str_replace("\n",'<br/>',$this->contenu);
		$contenu=mysql_real_escape_string($contenu);
		$tags=mysql_real_escape_string($this->tags);
		
		$result=mysql_query('SELECT idContenu FROM article WHERE idArticle=\''.$this->idArticle.'\';') or die ('Erreur SQL');
				
		if($data = mysql_fetch_array($result))
			$id=$data['idContenu'];
		else{
			deco();
			return "25";
		}
						
		//insertion dans la table du nouveau contenu
		$sql='UPDATE contenuPage, article SET contenuPage.contenu=\''.$contenu.'\', article.titre=\''.$titre.'\', article.tags=\''.$tags.'\' WHERE contenuPage.idContenu=\''.$id.'\' AND contenuPage.idContenu=article.idContenu;';
		mysql_query($sql) or die ('Erreur SQL : '.$sql);
		deco();
		
		return "8";
	}
	
	public function getIdArticle(){
		return $this->idArticle;
	}
	
	public function getDate(){
		return $this->date;
	}
	
	public function setDate($date){
		$this->date=$date;
	}
	
	public function getContenu(){
		return $this->contenu;
	}
	
	public function setContenu($contenu){
		$this->contenu=$contenu;
	}
	
	public function getTitre(){
		return $this->titre;
	}
	
	public function setTitre($titre){
		$this->titre=$titre;
	}
	
	public function getTags(){
		return $this->tags;
	}
	
	public function setTags($tags){
		$this->tags=$tags;
	}
	
	public function getCommentaires(){
		return $this->commentaires;
	}
	
	public function setCommentaires($commentaires){
		$this->commentaires=$commentaires;
	}	
}

?>
