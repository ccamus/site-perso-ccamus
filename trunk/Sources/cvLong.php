<?php
include('functions/affichage.php');
include('functions/InstallInfo.php');
enTete("cv, charlie, camus",$siteName." - CV (Long)");

echo '<h1>Mon curriculum vitae (version longue)</h1>
<br/>
<br/>    <div class="navbar">    <div class="navbar-inner">    <ul class="nav">    <li><a href="#presentation">Présentation</a></li>    <li><a href="#diplome">Diplôme</a></li>    <li><a href="#competences">Compétences</a></li>    <li><a href="#exp">Experience professionelle</a></li>    <li><a href="#plus">Informations complémentaires</a></li>    </ul>    </div>    </div>
<br/>
<br/><section id="presentation">
<br/>	
<br/>	<div class="page-header"><b>Camus Charlie</b></div>
<br/>
<br/>	Né le 25 septembre 1989
<br/>	e-mail: camus.charlie@gmail.com
<br/>	Site internet: camus.charlie.free.fr
<br/></section>
<br/>
<br/><section id="diplome">
<br/>	
<br/><div class="page-header"><b>Diplôme</b></div>
<br/><div class="row">	<div class="span4">2011</div><div class="span8">Licence professionnelle développement d\'applications - mention bien</div></div>
<br/><div class="row">	<div class="span4">2010</div><div class="span8">DUT informatique</div></div>
<br/><div class="row">	<div class="span4">2009</div><div class="span8">C2i</div></div>
<br/><div class="row">	<div class="span4">2008</div><div class="span8">BAC STI génie électronique - mention bien</div></div>
<br/><div class="row">	<div class="span4">2006</div><div class="span8">BEP électronique</div></div>
<br/></section>
<br/><section id="competences">
<br/>	
<br/><div class="page-header"><b>Compétences</b></div>
<br/><div class="row">	<div class="span4">Web technologies</div><div class="span8">J2EE, PHP (4/5), HTML, CSS, Wamp,  Lamp</div></div>
<br/><div class="row">	<div class="span4">Serveurs</div><div class="span8">Tomcat , Apache</div></div>
<br/><div class="row">	<div class="span4">Outils</div><div class="span8">Gestion de configuration : SVN
<br/> BPM : BONITASOFT 
<br/>Tests : JUnit , Quality Center
<br/>Virtualisation : VirtualBox
<br/>Intégration continue : MAVEN
<br/>phpMyAdmin, OpenLdap</div></div>
<br/><div class="row">	<div class="span4">Conception</div><div class="span8">UML, Merise (MCD, MLDââ‚¬Â¦),  W3C, MVC</div></div>
<br/><div class="row">	<div class="span4">Langages</div><div class="span8">JAVA, C, PHP, SQL, XML, XML schéma, XHTML, shell, Ksh, LDAP </div></div>
<br/><div class="row">	<div class="span4">Systèmes</div><div class="span8">Linux (Ubuntu 10.04, 12.04) , Unix  (solaris) </div></div>
<br/><div class="row">	<div class="span4">SGBD</div><div class="span8">MySQL (PL/SQL), TERADATA</div></div>
<br/><div class="row">	<div class="span4">Langue</div><div class="span8">Anglais</div></div>
<br/>
<br/><div class="row"><div class="span4">Conception</div><div class="span8">Spécifications fonctionnelles et techniques
<br/>Cahier des charges
<br/>Cahiers de test
<br/>Manuel d\'exploitation
<br/>Document de mise en production</div></div>
<br/></section>
<br/><section id="exp">
<br/>
<br/><div class="page-header"><b>EXPERIENCES PROFESSIONNELLES</b></div>
<br/>
<br/><div class="row">	<div class="span4">Du 22 août 2011 au 29 juin 2012</div><div class="span8">Travail en tant que développeur pour SII chez Bouyges Télécom : 
<br/>Projet Opéra : Mise en place et maintenance d\'un système datawarehouse.
<br/>
<br/>	Développement (JAVA) d\'un composant de communication entre la base de données et le logiciel d\'intégration de données.
<br/>     -Ecriture de requètes SQL générique
<br/>     -Développement des outils de communications utilisant les requètes
<br/>     -Ecriture de tests unitaires JUNIT
<br/>     -Test  d\'intégration et mise en place
<br/>     -Ecriture de documentations
<br/>	Maintenance applicative : Correction et évolution (jusqu\'à    3 semaines):
<br/>     -de scripts  ksh et sql
<br/>     -d\'interfaces ODI 
<br/>     -d\'automatisme (SDA)
<br/>     -de documentation.
<br/>     -Création de branche SVN.
<br/>	Insertion de nouveaux  flux de données (Informations quotidiennes)  dans la base cliente à   travers :
<br/>     -Le développement de scripts ksh, 
<br/>     -La conception de nouveaux scénarios ODI,
<br/>     -Des tests unitaires.
<br/>	 
<br/>KSH, SQL, ORACLE DATA INTEGRATOR, JAVA, UNIX (SOLARIS), MAVEN, TERADATA, SVN, QUALITY CENTER, JAVADOC</div></div>
<br/><div class="row">	<div class="span4">28 mars - 22 juillet 2011</div><div class="span8">Stage chez Manitou. Sujet du stage : étude et mise en place de solutions de BPM.
<br/>Projet BPM : Etude et mise en place de solutions de Business Process Management libre.
<br/>
<br/>	Etude du BPM (Bonitasoft)
<br/>	Recherche des solutions existantes
<br/>	Choix d\'une solution sur la base d\'une grille de tests
<br/>	Mise en place de processus
<br/>	Test des processus et correction.
<br/>	Communication vers l\'ensemble du service informatique afin de reporter l\'idée de ce qu\'est le BPM.
<br/>	Modification de l\'application afin de la faire fonctionner avec un LDAP :
<br/>     -Découverte et installation d\'OpenLdap
<br/>     -Création d\'un arbre dans l\'LDAP
<br/>     -Rédaction d\'une documentation concernant les étapes précédentes
<br/>     -Modification de Bonitasoft afin de le mettre en relation avec l\'LDAP
<br/>	Passage des connaissances
<br/>
<br/>Projet Alfresco & Liferay: 
<br/>
<br/>	Découvert de Liferay et d\'Alfresco
<br/>	Création d\'une portlet de communication entre les deux outils
<br/>
<br/>Projet transverse : 
<br/>
<br/>	Création d\'un script PHP de recherche de mots clé dans un fichier CSV de grande envergure.
<br/>	
<br/>JEE, TOMCAT, MYSQL, GROOVY, SQL, BONITASOFT, OPENLDAP, PHP, LIFERAY, ALFRESCO</div></div>
<br/><div class="row">	<div class="span4">Année 2010-2011</div><div class="span8">Cours d\'informatique pour particulier (sujet au choix du client).</div></div>
<br/><div class="row">	<div class="span4">Août 2010</div><div class="span8">CDD en tant que développeur chez Logosapience. Développement d\'une application de gestion de clients et de licences.
<br/>	Etude du cahier des charges et de l\'existant.
<br/>	Développement de l\'application
<br/>	Présentation d\'une première version.
<br/>	Passage des connaissances
<br/>	
<br/>	JAVA, MYSQL, SQL, ECLIPSE, LINUX (UBUNTU)</div></div>
<br/><div class="row">	<div class="span4">5 Avril au 20 Juin 2010</div><div class="span8">Stage en entreprise (Logosapience) en tant que développeur. Travail sur un système de mise à   jour automatique.
<br/>	Etude du cahier des charges et de l\'existant.
<br/>	Recherche de solutions possible.
<br/>	Rédaction des spécifications.
<br/>	Réalisation de l\'application
<br/>	Test du fonctionnement de l\'application dans le système.
<br/>
<br/>JAVA, MYSQL, POSTEGRES, PHP (4/5), ECLIPSE, LINUX (UBUNTU)</div></div>
<br/><div class="row">	<div class="span4">Juillet 2008 à   Février 2010</div><div class="span8">Travail (saisonnier) en tant qu\'ouvrier de production dans une usine dââ‚¬â„¢alimentaire ( Pasquier aux Cerqueux).</div></div>
<br/><div class="row">	<div class="span4">Mai 2008</div><div class="span8">Travail dans une usine en tant que câbleur (Grolleau-Montilliers).</div></div>
<br/><div class="row">	<div class="span4">2005</div><div class="span8">Stage en entreprise de réparation de hi-fi vidéo et électroménager.</div></div>
<br/></section>
<br/><section id="plus">
<br/>
<br/><div class="page-header"><b>INFORMATIONS COMPLEMENTAIRES</b></div>
<br/>
<br/>Permis de conduire, voiture, bon niveau d\'anglais.
<br/>
<br/>
<br/><div class="page-header"><b>LOISIRS</b></div>
<br/>
<br/>Musique (tout style), informatique, lecture tout support et tout style, joue de la guitare électrique, passion pour Linux et le logiciel libre, cinéphile (tout style), boxe, cuisine, écriture de nouvelles de science-fiction.
<br/></section>
<br/>
<br/><a href="CV.pdf">télécharger le CV en PDF</a>
<br/>
<br/>
<br/>';
basPage();

?>