alter table lien add tags text;

Create table article (
	idArticle int(11) NOT NULL auto_increment,
	dateArticle datetime NOT NULL,
	titre char(50) NOT NULL,
	tags text,
	idContenu int(11) NOT NULL,
	PRIMARY KEY  (`idArticle`)
);
