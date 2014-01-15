CREATE TABLE categorie(
	idCategorie INTEGER PRIMARY KEY,
	labelCategorie CHAR(50) NOT NULL
);

ALTER TABLE article ADD idCategorie INTEGER NOT NULL DEFAULT 0;
ALTER TABLE article ADD contenu TEXT NOT NULL DEFAULT "";

INSERT OR REPLACE INTO article 
SELECT idArticle, titre, tags, contenuPage.idContenu, dateArticle, idCategorie, contenuPage.contenu
FROM article JOIN contenuPage ON article.idContenu = contenuPage.idContenu;

ALTER TABLE article DROP idContenu;

DROP TABLE lien;
DROP TABLE contenuPage;