<?php
include('functions/affichage.php');
include('functions/InstallInfo.php');
enTete("cv, charlie, camus",$siteName." - CV (court)");

echo '<h1>Mon curriculum vitae</h1>
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
<br/><div class="page-header"><b>Experience professionelle</b></div>
<br/><div class="row">	<div class="span4">Du 22 août 2011 au 29 juin 2012</div><div class="span8">Travail en tant que développeur pour SII chez Bouyges Télécom.</div></div>
<br/><div class="row">	<div class="span4">28 mars - 22 juillet 2011</div><div class="span8">Stage chez Manitou. Sujet du stage : étude et mise en place de solutions de BPM.</div></div>
<br/><div class="row">	<div class="span4">Année 2010-2011</div><div class="span8">Cours d\'informatique pour particulier (sujet au choix du client).</div></div>
<br/><div class="row">	<div class="span4">Août 2010</div><div class="span8">CDD en tant que développeur chez Logosapience. Développement d\'une application de gestion de clients et de licences.</div></div>
<br/><div class="row">	<div class="span4">5 Avril au 20 Juin 2010</div><div class="span8">Stage en entreprise (Logosapience) en tant que développeur. Travail sur un système de mise à   jour automatique.</div></div>
<br/><div class="row">	<div class="span4">Juillet 2008 à   Février 2010</div><div class="span8">Travail (saisonnier) en tant qu\'ouvrier de production dans une usine dââ‚¬â„¢alimentaire ( Pasquier aux Cerqueux).</div></div>
<br/><div class="row">	<div class="span4">Mai 2008</div><div class="span8">Travail dans une usine en tant que câbleur (Grolleau-Montilliers).</div></div>
<br/><div class="row">	<div class="span4">2005</div><div class="span8">Stage en entreprise de réparation de hi-fi vidéo et électroménager.</div></div>
<br/></section>
<br/><section id="plus">
<br/>	
<br/><div class="page-header"><b>Informations complémentaires</b></div>
<br/>
<br/>Permis de conduire, voiture, bon niveau d\'anglais.
<br/>
<br/>
<br/><div class="page-header"><b>Loisirs</b></div>
<br/>
<br/>Musique (tout style), informatique, lecture tout support et tout style, joue de la guitare électrique, passion pour Linux et le logiciel libre, cinéphile (tout style), boxe, roller, natation, course à   pied, cuisine, écriture de nouvelles de science-fiction.
<br/></section>
<br/>
<br/><a href="CV.pdf">télécharger le CV en PDF</a>
<br/>
<br/>
<br/>';
basPage();

?>