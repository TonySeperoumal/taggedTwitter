<?php
	session_start();
	include('config.php');
	include('db_connexion.php');
	include('fonctions.php');
	include('vendor/autoload.php');
	
	$messages = "";
	$errorMessages = "";
	$tag_id = "";
	

	if (!empty($_POST)){

		$messages = trim(strip_tags($_POST['messages']));
		$tag_id = trim(strip_tags($_POST['tag_id']));
	


		if (empty($messages)){
			$errormessages = "Veuillez ecrire votre message !";
		}
		else if (strlen($messages) > 140 || strlen($messages) <=2){
			$errorTweet = "Votre message doit avoir entre 2 et 140 caractères !";
		}
		if ($errorMessages == ""){
			$sql = "INSERT INTO tweets(id, user_id, tag_id, messages, date_created, date_modified)
					VALUES (NULL, :user_id, :tag_id, :messages, NOW(), NOW())";
			$sth = $dbh->prepare($sql);
			$sth->bindValue(':messages', $messages);
			$sth->bindValue(':user_id', $_SESSION['user']['id']);
			$sth->bindValue(':tag_id' , $tag_id);			
			$sth->execute();
		}	

		

	}

	$sql = "SELECT id, messages 
		FROM tweets
		ORDER BY date_created DESC
		LIMIT 10";
	$sth = $dbh->prepare($sql);
	$sth->execute();
	$tweets = $sth->fetchAll();
	
	// pr($tweets);

	// $sql = "SELECT users.username, tweets.messages
	// 		FROM users
	// 		LEFT JOIN tweets
	// 		ON users.id = tweets.user_id";
	// $sth = $dbh->prepare($sql);
	// $sth -> execute();
	
	


?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>	
</head>
<body>
	<div class="container">
		<h1><?php echo $_SESSION['user']['username']; ?> connecté</h1>
		<div class="create">
			<form action="home.php" method="post">
				<label for="messages">
					<input class="form-control" type="text" value="<?php echo $messages; ?>" name="messages" id="messages">
					<input type="submit" value="Ok"><span><a href="logout.php">Déconnexion</a></span>
				<div class="help-block text-danger"><?php echo $errorMessages; ?></div>
				</label>
				<label for="tag_id">
					<input type="hidden" name="tag_id" id="tag_id">	
				</label>
			</form>
		</div>
		<div class="result">			
			<h2 id="result"></h2>					
		</div>
		<div class="show-tweets">
			<?php
			foreach ($tweets as $tweet) {
				?>
				<div>
					<p><?php echo $tweet["messages"] ?></p>
					
					<?php
				}

			?>
		</div>
				

	</div>
	<script type="text/javascript" src="js/jQuery.js"></script>
	<script>

		$(window).on('load', function(){
			$.ajax({
				"url": "tags.php"
			}).done(function(response){
				$('#result').html(response);
			});
		});
		window.setInterval(function(){
			$.ajax({
				"url": "tags.php"
			}).done(function(response){
				// console.log(response);
				$('#result').html(response);
			});
		},2000);


		$(window).on('load' , function(){
			$.ajax({
				"url": "tag_id.php"
			}).done(function(response){
				$('#tag_id').attr("value" , response);
			});
		});
		window.setInterval(function(){
			$.ajax({
				"url": "tag_id.php"
			}).done(function(response){
				console.log(response);
				$('#tag_id').attr("value" , response);
			});
		},2000);

	</script>

</body>
</html>