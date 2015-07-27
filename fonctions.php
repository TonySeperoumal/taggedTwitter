<?php

	//mes fonctions


		//convertit une date au format MySQL, vers le francais
		function convertDateToFrench($dateMysql){

			$unix = strtotime($dateMysql);
			$frenchDate = date("d-m-y H:i:s", $unix);

			return $frenchDate;
		}
		
		//pour l'envoi automatique des emails
		function getConfiguredMailer(){
			$mail = new PHPMailer;
			//config de l'envoi
			$mail->isSMTP();
			$mail->setLanguage('fr');
			$mail->CharSet = 'UTF-8';
			//debug
			$mail->SMTPDebug = 0;	//0 pour désactiver les infos de débug
			$mail->Debugoutput = 'html';
			//config du serveur smtp
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Username = SMTPUSER;
			$mail->Password = SMTPPASS;
			//mail au format HTML
			$mail->isHTML(true); 
			return $mail;
		}

		//affiche un array dans une balise <pre>
		function pr($table){

			echo '<pre>';
			print_r($table);
			echo '</pre>';
		}

		//si l'utilisteur n'est pas connecté
		function lock(){

			//si on a oublié d'appeler session_start()
			if (!isset($session)){
				session_start();
			}

			if (empty($_SESSION['user'])){
		header('location: login.php');
		die();
			}

		}