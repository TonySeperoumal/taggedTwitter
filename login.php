<?php
	session_start();
	include('config.php');
	include('db_connexion.php');
	include('fonctions.php');

	


?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div class="container">

		<h1>Connection</h1>

		<form action="login_handler.php" method="post">			
			<input type="text" name="email" placeholder="Email or username">Nom d'utilisateur
			<input type="password" name="password" placeholder="Password">Mot de passe

			<button type="submit">Envoyer</button><br />
			<input type="checkbox" name="remember" id="remember" value="1">Restez connecté

			<a href="forgot_password_2.php">Mot de passe oublié</a>
		</form>
		<?php
			//si on a stocké un message d'erreur (dans login_handler.php)
			if (!empty($_SESSION['login_error'])){
			//affiche le messsage d'erreur
			 echo $_SESSION['login_error'];
			//on a affiché le message, alors on peut le virer
			 unset($_SESSION['login_error']);
			}
		?>
		




	</div>
	
</body>
</html>