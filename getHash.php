<?php
	if(isset($_POST['pseudo']) && isset($_POST['pass']) && $_POST['pseudo']!="" && $_POST['pass']!=""){
			//il a entré des infos
			$pseudo=$_POST['pseudo'];
			$mdp=$_POST['pass'];
			
			echo "le mot de passe crypté : ".md5($mdp)."<br/>";
			echo "le username : ".$pseudo."<br/><br/>";
			echo "la requête d'insertion : INSERT INTO users (nom,mdp) VALUES ('".$pseudo."', '".md5($mdp)."')";
			
	}else{			
		// il veut avoir un login et mot de passe
		echo '<h1>Récupération de données pour le compte</h1><br/><br/><br/>
			<table>
			<form method="post" action="getHash.php">
				<tr>
					<td><label for="pseudo">Nom de connexion :</label></td>
					<td><input type="text" name="pseudo" id="pseudo" size=10/></td>
				</tr>
				<tr>
					<td><label for="pass">Votre mot de passe :</label></td>
					<td><input type="password" name="pass" id="pass" size=10/></td>
				</tr>
				<tr>
					<td></td><td><input type="submit" /></td>
				</tr>
			</form>
			</table>';
	}
?>
