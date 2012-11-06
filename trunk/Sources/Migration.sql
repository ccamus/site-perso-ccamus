alter table lien add tags text;

Create table article (
	idArticle int(11) NOT NULL auto_increment,
	dateArticle datetime NOT NULL,
	titre char(50) NOT NULL,
	tags text,
	idContenu int(11) NOT NULL,
	PRIMARY KEY  (`idArticle`)
);

Create table commentaire (
	idCommentaire int(11) NOT NULL auto_increment,
	dateComm datetime NOT NULL,
	commentateur char(50) NOT NULL,
	commentaire text,
	idArticle int(11) NOT NULL,
	PRIMARY KEY  (`idCommentaire`)
);
