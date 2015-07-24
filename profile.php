<?php

	session_start();

	include("fonctions.php");
	pr($_SESSION);

	lock();

?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<meta charset="UTF-8">
	<title>Profil !</title>
</head>
<body>

	<a href="logout.php" title="Me déconnecter de mon compte">Déconnexion</a>

	<h1>Profil de <?php echo $_SESSION['user']['username']; ?></h1>
	<p>Cette page ne devrait accessible que pour les utilisateurs connectés.</p>
</body>
</html>