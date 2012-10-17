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
			getBDD();
			
			$id=mysql_real_escape_string($id);
			
			$result=mysql_query('SELECT date, contenu, titre, tags FROM contenuPage, article WHERE idArticle=\''.$id.'\' AND contenuPage.idContenu=article.idContenu') or die ('Erreur SQL');

			if( ! $data = mysql_fetch_array($result)){
				$rep="24";
			}else{				
				$this->idArticle=$id;
				$this->date=$data['date'];
				$this->contenu=stripslashes($data['contenu']);
				$this->titre=$data['titre'];
				$this->tags=$data['tags'];
			}
		}
		
		deco();		
		
		return $rep;
	}
	
	//Enregistre un article en base
	public function add(){
		
	}
	
	public function getIdArticle(){
		return $this->idArticle;
	}
	
	public function setIdArticle($idArticle){
		$this->idArticle=$idArticle;
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
