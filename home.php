<?php
	session_start();
	include('config.php');
	include('db_connexion.php');
	include('fonctions.php');
	include('vendor/autoload.php');
	pr($_SESSION['user']);
	$messages = "";
	$errorMessages = "";

	if (!empty($_POST)){

		$messages = trim(strip_tags($_POST['messages']));

		if (empty($messages)){
			$errormessages = "Veuillez ecrire votre message !";
		}
		else if (strlen($messages) > 140 || strlen($messages) <=2){
			$errorTweet = "Votre message doit avoir entre 2 et 140 caractères !";
		}
		if ($errorMessages == ""){
			$sql = "INSERT INTO tweets(id, user_id, messages, date_created, date_modified)
					VALUES (NULL, :user_id, :messages, NOW(), NOW())";
			$sth = $dbh->prepare($sql);
			$sth->bindValue(':messages', $messages);
			$sth->bindValue(':user_id', $_SESSION['user']['id']);
			$sth->execute();
		}	

		// pr($_POST);

	}

	$sql = "SELECT id, messages 
		FROM tweets
		ORDER BY date_created DESC";
	$sth = $dbh->prepare($sql);
	$sth->execute();
	$tweets = $sth->fetchAll();
	
	// pr($tweets);

	$sql = "SELECT users.username, tweets.messages
			FROM users
			LEFT JOIN tweets
			ON users.id = tweets.user_id";
	$sth = $dbh->prepare($sql);
	$sth -> execute();
	
	


?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div class="container">
		<div class="create">
			<form action="home.php" method="post">
				<label for="messages">
				<input class="form-control" type="text" value="<?php echo $messages; ?>" name="messages" id="messages">
				<input type="submit" value="Ok">
				<div class="help-block text-danger"><?php echo $errorMessages; ?></div>
				</label>
			</form>
		</div>
		<div class="show">
			<?php
			foreach ($tweets as $tweet) {
				?>
				<div>
					<h2><?php echo $tweet["messages"] ?></h2>
					
					<?php
				}

			?>
		</div>		

	</div>

</body>
</html>