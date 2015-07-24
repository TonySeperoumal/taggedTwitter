<?php

	session_start();

	include("config.php");
	include("db.php");
	include("fonctions.php");
	include("vendor/autoload.php");

	if(!empty($_POST)){

		$error = "";

		$email = trim(strip_tags($_POST['email']));

		if(empty($email)){
			$error = "Veuillez renseigner votre email !";
		}

		elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$error = "Votre email n'est pas valide !";
		}
		//email trop long ?
		elseif(strlen($email) > 100){
			$error = "Votre email est trop long.";
		}

		if ($error == ""){

			$sql = "SELECT * FROM users WHERE email = :email";
			$sth = $dbh->prepare($sql);
			//l'array remplace le bindValue()
			$sth->execute(array(":email" => $email));
			$user = $sth->fetch();

				if ($user){
				
				$factory = new RandomLib\Factory;
				$generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));
				$token = $generator->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-');

				$expiry = date("Y-m-d H:i:s", strtotime("+ 1 day"));

				$sql = "UPDATE users 
						SET token = :token,
						token_expiry = :expiry,
						date_modified = NOW() 
						WHERE id = :id";

				$hashedToken = password_hash($token, PASSWORD_DEFAULT);

				$sth = $dbh->prepare($sql);
				$sth->bindValue(":token", $hashedToken);
				$sth->bindValue(":expiry", $expiry);
				$sth->bindValue(":id", $user['id']);

				if ($sth->execute()){

					$resetLink = ROOTURL . "/forgot_password.php?token=$token&email=$email";

					$mail = getConfiguredMailer();

					//qui envoie, et qui reçoit
					$mail->setFrom('tony.wf3.nanterre@gmail.com', 'Tony-Administrateur');
					$mail->addAddress('fred-paris@gmail.com', 'Fred');
					$mail->addAddress($email, $user['username']);

					$mail->Subject = 'Mot de passe oublié';

					$mail->Body = 
					'<p>Vous avez oublié votre mot de passe taggedTwitter ?<br />
					<a href="'.$resetLink.'">
					Cliquez ici pour créer un nouveau mot de passe</a></p>
					<p>Si vous n\'êtes pas à l\'origine de cette demande, vous pouvez ignorer ce message</p>';

					//pièce jointe
					//$mail->addAttachment('panda.gif');

					if (!$mail->send()) {
						$error = "Une erreur de survenue. Le mail n'a pas été envoyé !";
					} else {
						$message = "Allez voir vos mails !";
					}
				}
				else {
				$error = "Cet email n'est pas inscrit ici !";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<meta charset="UTF-8">
	<title>Mot de passe oublié</title>
</head>

<body>
	
	<h1>Mot de passe oublié</h1>

	<p>Veuillez entrer l'adresse email utilisée lors de votre inscription.</p>
	<p>Nous y enverrons un message permettant de créer un nouveau mot de passe.</p>
	<form method="POST">
		<input type="text" name="email" placeholder="Votre email" />
		<input type="submit" value="OK" />
	</form>
	<div>
	<?php 
		if (!empty($error)){
			echo $error;
		}
	?>
	</div>
	<div>
	<?php 
		if (!empty($message)){
			echo $message;
		}
	?>
	</div>

</body>
</html>

