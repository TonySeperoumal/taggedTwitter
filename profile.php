<?php

	session_start();
	include('config.php');
	include('db_connexion.php');
	include('vendor/auload.php')
	include("fonctions.php");
	// pr($_SESSION);

	lock();

?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<meta charset="UTF-8">
	<title>Profil !</title>
</head>
<body>


	<h1>Profil de <?php echo $_SESSION['user']['username']; ?></h1>
	<p>Cette page ne devrait accessible que pour les utilisateurs connectés.</p>
	<a href="logout.php" title="Me déconnecter de mon compte">Déconnexion</a>
</body>
</html>