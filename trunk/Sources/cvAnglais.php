<?php
include('functions/affichage.php');
include('functions/InstallInfo.php');
enTete("cv, anglais, charlie, camus",$siteName." - English CV");

echo '<h1>My curriculum vitae</h1>
<br/>				<div id=\'center\'>English version</div>
<br/>				
<br/>    <div class="navbar">    <div class="navbar-inner">    <ul class="nav">    <li><a href="#presentation">Presentation</a></li>    <li><a href="#diplome">Degrees</a></li>    <li><a href="#competences">Skills</a></li>    <li><a href="#exp">Professional experiences</a></li>    <li><a href="#plus">Complementary informations</a></li>    </ul>    </div>    </div>
<br/>
<br/><section id="presentation">
<br/>	
<br/>	<div class="page-header"><b>Camus Charlie</b></div>
<br/>
<br/>	Born in 25th September 1989
<br/>	e-mail: camus.charlie@gmail.com
<br/>	Web site: camus.charlie.free.fr
<br/></section>
<br/>
<br/><section id="diplome">
<br/>	
<br/><div class="page-header"><b>Degrees</b></div>
<br/><div class="row">	<div class="span4">2011</div><div class="span8">Bachelor\'s professional degree</div></div>
<br/><div class="row">	<div class="span4">2010</div><div class="span8">H.N.D. in computing sciences</div></div>
<br/><div class="row">	<div class="span4">2009</div><div class="span8">C2i (office certificate)</div></div>
<br/><div class="row">	<div class="span4">2008</div><div class="span8"> Equivalent to an A level specialized in electronic sciences</div></div>
<br/><div class="row">	<div class="span4">2006</div><div class="span8">Technical School Certificate in electronic</div></div>
<br/></section>
<br/><section id="competences">
<br/>	
<br/><div class="page-header"><b>Skills</b></div>
<br/><div class="row">	<div class="span4">Web technologies</div><div class="span8">J2EE, PHP (4/5), HTML, CSS, Wamp,  Lamp</div></div>
<br/><div class="row">	<div class="span4">Server</div><div class="span8">Tomcat , Apache</div></div>
<br/><div class="row">	<div class="span4">Tools</div><div class="span8">Configuration administration : SVN
<br/> BPM : BONITASOFT 
<br/>Tests : JUnit , Quality Center
<br/>Virtualisation : VirtualBox
<br/>Continue integration : MAVEN
<br/>phpMyAdmin, OpenLdap</div></div>
<br/><div class="row">	<div class="span4">Conception</div><div class="span8">UML, Merise (MCD, MLDââ‚¬Â¦),  W3C, MVC</div></div>
<br/><div class="row">	<div class="span4">Languages</div><div class="span8">JAVA, C, PHP, SQL, XML, XML schéma, XHTML, shell, Ksh, LDAP </div></div>
<br/><div class="row">	<div class="span4">Systems</div><div class="span8">Linux (Ubuntu 10.04, 12.04) , Unix  (solaris) </div></div>
<br/><div class="row">	<div class="span4">DBMS</div><div class="span8">MySQL (PL/SQL), TERADATA</div></div>
<br/><div class="row">	<div class="span4">Languages</div><div class="span8">French, English</div></div>
<br/>
<br/><div class="row"><div class="span4">Conception</div><div class="span8">Functionnal and technical specifications
<br/>Test plan
<br/>Exploitation manual
<br/>Installation plan</div></div>
<br/></section>
<br/><section id="exp">
<br/>	
<br/><div class="page-header"><b>Professional experiences</b></div>
<br/><div class="row">	<div class="span4">from 22th august 2011 to 29th june 2012</div><div class="span8">Work as a developer for SII to Bouyges Télécom.</div></div>
<br/><div class="row">	<div class="span4">from 28th march to 22th july 2011</div><div class="span8">Training period in Manitou. Subject of the training : Study and establishment of a BPM solution.</div></div>
<br/><div class="row">	<div class="span4">2010-2011</div><div class="span8">Computing sciences lessons to particular.</div></div>
<br/><div class="row">	<div class="span4">august 2010</div><div class="span8">Work as a developer for Logosapience. Developement of a customer management application.</div></div>
<br/><div class="row">	<div class="span4">from 5th april to 20th june 2010</div><div class="span8">Training period in Logosapience as a developer. Work on an automatic update system.</div></div>
<br/><div class="row">	<div class="span4">from july 2008 to february 2010</div><div class="span8">Work (seasonal) as a production worker in a food factory.</div></div>
<br/></section>
<br/><section id="plus">
<br/>	
<br/><div class="page-header"><b>Complementary informations</b></div>
<br/>
<br/>Driving license, got a car.
<br/>
<br/>
<br/><div class="page-header"><b>Interests</b></div>
<br/>
<br/>Music, computing sciences, reading all supports and all styles, cinema lover (all styles), boxing, roller, swimming, running, cooking, writing of science-fiction novel.
<br/></section>
<br/>
<br/>
<br/>';
basPage();
?>