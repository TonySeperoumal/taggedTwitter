<?php
	
	include('config.php');
	include('db_connexion.php');

	

	$sql = "SELECT users.username, tweet_id.messages
			FROM users
			LEFT JOIN tweet_id
			ON users.id = tweet_id.users_id";
	$sth = $dbh->prepare($sql);
	$sth->execute();

	
	


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
			<form action="message">
				<label for="message">
				<input class="form-control" type="text" value="<?php echo $message; ?>" name="message" id="message">
				<div class="help-block text-danger"><?php echo $errorTitle; ?></div>
				</label>
			</form>

		</div>
		<div class="screen">
			<?php
				foreach ($shows as $show) {
					?>
					<div>
						<h2><?php echo $show['messages'] ?></h2>
						<a href="details.php?id=<?php echo $how["id"] ?>">détails</a>
						<?php
				}

			?>
		</div>		

	</div>

</body>
</html>