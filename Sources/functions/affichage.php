<?php
	function enTete($tag = null){
		echo '<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Site web de Charlie Camus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site web de Charlie Camus">';
    if(!is_null($tag)){
		echo '<meta name="Keywords" content="'.$tag.'">';
	}
    echo '<meta name="author" content="Charlie Camus">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css" type="text/css" charset="UTF-8" /> 
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link rel="stylesheet" href="google-code-prettify/prettify.css" type="text/css" charset="UTF-8" /> 
	<script type="text/javascript" src="google-code-prettify/prettify.js"></script>
	<link rel="stylesheet" href="generated/stylePerso.css" type="text/css" charset="UTF-8" /> 
	

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
   <link rel="shortcut icon" href="favicon/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="favicon/favicon144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="favicon/favicon114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="favicon/favicon72.png">
    <link rel="apple-touch-icon-precomposed" href="favicon/favicon57.png">
  </head>

  <body onload="prettyPrint()">';
						
		include("generated/menu.php");
				
		echo '	<div class="container">';
		
		if(isset($_GET['message']) && $_GET['message']!=''){
			include('messages.php');
			if($msgs[$_GET['message']]!=""){
				if($isError[$_GET['message']]=="1"){
					echo '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<h4>Erreur!</h4>'.$msgs[$_GET['message']].'</div>';
				}else{
					echo '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<h4>:)</h4>'.$msgs[$_GET['message']].'</div>';
				}
			}
		}
	}
	
	function echoStyle(){
		$monfichier = fopen('generated/stylePerso.css', 'r');
		
		echo '<p>Styles personnalisés :<br/>
						<table class="table">';
		while (!feof($monfichier)) { //on parcourt toutes les lignes
			$ligne = fgets($monfichier, 4096); // lecture du contenu de la ligne
			if(preg_match("#^/\*.*\*/$#",trim($ligne))==1){
				$commentaire=trim($ligne);
				if(!feof($monfichier)){
					$style=fgets($monfichier, 4096);
					$nom=trim(ereg_replace("/\*|\*/","",$commentaire));
					if(preg_match("/^\.(.)*$/",trim($style))==1){
						$style="&lt;div class=\"".trim(ereg_replace("#|\.|\{","",$style))."\"&gt;...&lt;/div&gt;";
					}else if(preg_match("/^#(.)*$/",trim($style))==1){
						$style="&lt;div id=\"".trim(ereg_replace("#|\.|\{","",$style))."\"&gt;...&lt;/div&gt;";					
					}else{
						$style=trim(ereg_replace("#|\.|\{","",$style));
					}
					$style=trim(ereg_replace("#|\.|\{","",$style));
					echo '<tr><td>'.$nom.' : </td><td>'.$style.'</td></tr>';
				}
			}
		}
		echo '				</table>
					</p>';
		fclose($monfichier);
	}
	
	function basPage(){
		echo '		
		</div>
	<footer class="footer">
      <div class="container">
		<p class="pull-right"><span class="label"><a href="#">Haut de page</a></span></p>
        <p>Site web entièrement réalisé par <a href="mailto:camus.charlie@gmail.com">Charlie Camus</a>.</p>
        <p>Style réalisé par <a href="http://twitter.com/twitter" target="_blank">@twitter</a> : <a href="http://twitter.github.com/bootstrap/index.html">Twitter Bootstrap</a> sous la <a href="http://www.apache.org/licenses/LICENSE-2.0">licence Apache V2.0</a>.</p>
        <p>Icones provenant de <a href="http://glyphicons.com">Glyphicons Free</a>, sous licence <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
      </div>
    </footer>
		
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

  

</body></html>';	
	}
?>
