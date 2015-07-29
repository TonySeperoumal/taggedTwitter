<!doctype html>
<html lang="fr-FR">

<head>
	<meta charset="UTF-8">
	<title>Votre photo de profil</title>

	<style>
		input{display: block;}
	</style>
</head>

<body>

	<h1>Votre photo de profil</h1>

	
 	<form method="POST" action="handle_upload.php" enctype="multipart/form-data">
	
		<?php //MAX_FILE_SIZE : pas vraiment utile, car ça n'a aucune valeur de sécurité vu que ça vient du client ?>

		<label for="pic">Chosissez un fichier :</label>
<!-- 	input type file est par défaut difficile à styliser
 -->	<input type="file" name="pic" id="pic" />

		<input type="submit" value="Envoyer !" />

	</form>

</body>
</html>
