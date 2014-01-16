<?php

include('functions/InstallInfo.php');

echo ' <div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">

			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
			<a class="navbar-brand" title="Retour accueil" href="'.$localisationServeur.'">@Charlie</a>
		</div>
		
		<div class="collapse navbar-collapse">
			<form class="navbar-form navbar-left" role="search" method="post" action="index.php?mod=search">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Mot clé de recherche" name="searchWords">
				</div>
				<button type="submit" class="btn btn-primary" title="Lancer la recherche">Rechercher</button>
			</form>

			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Curriculum Vitae<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href=\'CV/CV.pdf\'>En PDF</a></li>
						<li><a href=\'cv.php?cv=1\'>CV (long)</a></li>
						<li><a href=\'cv.php?cv=2\'>CV (court)</a></li>
						<li><a href=\'cv.php?cv=3\'>English CV</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href=\'adminInterface.php\'>Administration</a>
				</li>
			</ul>
		</div>
	</div>
</div>';

?>