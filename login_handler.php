<?php
	session_start();
	include('config.php');
	include('db_connexion.php');
	include('vendor/autoload.php');

	// print_r($_POST);




	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM users
			WHERE email = :email
			OR username = :email
			LIMIT 1";

	$sth = $dbh->prepare($sql);
	$sth->bindvalue(':email', $email);
	$sth->execute();

	$foundUser = $sth->fetch();

	if ($foundUser){
		print_r($foundUser);

		$isValidPassword = password_verify($password, $foundUser['password']);
		
		// echo $token;
		// die();		
		
		if ($isValidPassword){
			unset($foundUser['password']);
			$_SESSION['user'] = $foundUser;
			header('location: protected_page.php');
			die();
		}
		else{			
			$_SESSION['login_error'] = "Erreur d'identification !";
			header('location: login.php');
			die();
		}
	
}
else {
		$_SESSION['login_error'] = "Erreur d'identification !";
		header('location: login.php');
		die();
}

?>