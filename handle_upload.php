<?php

	session_start();

	include("config.php");
	include("db_connexion.php");
	include("fonctions.php");
	include("vendor/autoload.php");


$maxSize = 2000000;

$acceptedMimes = array("image/jpeg", "image/gif", "image/png");

$acceptedExtensions = array("jpeg", "jpg", "gif", "png");
$minWidth = 150;
$minHeight = 150;

print_r($_FILES);

//si on a des fichiers uploadés...
//attention : $_FILES ne sera pas vide si on ne sélectionne pas de fichier !
if($_FILES['pic']['error'] != 4) {


	//initialisation de notre variable d'erreur
	$error = "";

	echo '<pre style="background-color:#2c3e50; color:#fff; font-size:14px; 
		font-family: Consolas, Monospace; padding:20px;">';
	print_r($_FILES);
	echo '</pre>';

	//chemin vers le fichier uploadé
	$tmpName = $_FILES['pic']['tmp_name'];

	//erreurs d'upload détectées par PHP ?
	if ($_FILES['pic']['error'] != 0) {
		//liste des erreurs ici : http://php.net/manual/fr/features.file-upload.php
		switch($_FILES['pic']['error']) {
			case 1:
				$error = "Votre fichier est trop gros !";
				break;
			case 4:
				$error = "Aucun fichier n'a été sélectionné !";
				break;
			default:
				$error = "Une erreur est survenue lors du chargement du fichier !";
			break;
		}
	}

	//le poids de l'image est ok ?
	if ($_FILES['pic']['size'] > $maxSize){
		$error = "Votre image est trop lourde ! $maxSize octets maximum !";
	}

	//largeur et hauteur ok ?
	$imageSizes = getimagesize($tmpName);
	if ($imageSizes[0] < $minWidth){
		$error = "Votre image n'est pas assez large ! $minWidth pixels minimum !";
	}
	elseif ($imageSizes[1] < $minHeight){
		$error = "Votre image n'est pas assez haute ! $minHeight pixels minimum !";
	}

	//extension du fichier
	$ext = pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION);

	//l'extension est dans notre white list ?
	if(!in_array(strtolower($ext), $acceptedExtensions)){
		$error = "Ce type de fichier n'est pas accepté !";
	}

	//vérifie le type mime
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	$mime = finfo_file($finfo, $tmpName);

	// //liste des types mime : http://www.sitepoint.com/web-foundations/mime-types-complete-list/
	// die($mime);

	//le type mime détecté est accepté ?
	if (!in_array($mime, $acceptedMimes)){
		$error = "Type de fichier refusé !";
	}

	//si on n'a pas détecté d'erreurs, on poursuit avec l'upload...
	if(empty($error)){
		
		// die($ext);

		//générer nouveau nom du fichier, sécuritaire contre les XSS, les espaces, les guillemets, etc..
		$newName = md5($tmpName . time() . uniqid()) . "." . $ext;

		//chemin vers le répertoire où on veut déplacer l'image
		//chemin vers le fichier actuel
		$destinationDirectory = __DIR__ . "/pictures/uploads/";

		//avant de déplacer le fichier, on teste s'il existe déjà avec ce nom (hasard malheureux)
		if(file_exists($destinationDirectory . "originals/" . $newName)){
			//on ajoute un identifiant unique (basé sur le temps) à la fin du fichier
			$newName = md5($tmpName . time() . uniqid()) . uniqid() . "." . $ext;
		}

		//déplace le fichier temporaire vers un autre répertoire sur notre serveur
		// move_uploaded_file($tmpName, $destinationDirectory . $_FILES['pic']['name']);

		//maintenant que ça marche; il faut sécuriser tout ça : on n'a pas vérifié le 
		//type de fichier (image ou pas ?), la taille du fichier (on ne veut pas trop gros), et la personne 
		//peut avoir mis des balises script ds son nom de fichier...
		//donc on ne va jamais utiliser le nom de fichier original des gens; on n'essaye même
		//pas de purifier le nom de fichier
		//on va hasher le nom de fichier, quelquesoit son nom de départ. on remonte 
		//au-dessus à "nouveau nom du fichier", et la ligne 22 devient :
		move_uploaded_file($tmpName, $destinationDirectory . "originals/" . $newName);

		$img = new abeautifulsite\SimpleImage($destinationDirectory . "originals/" . $newName);
		//mediums
		$img->best_fit(600,600)->save($destinationDirectory . "mediums/" . $newName);
		//thumbnails
		$img->thumbnail(150,150)->save($destinationDirectory . "thumbnails/" . $newName);
		// ou en sepia :
		// $img->thumbnail(150,150)->sepia()->save($destinationDirectory . "thumbnails/" . $newName);

		$sql = "UPDATE users
			SET pictures = :pictures
			date_modified = NOW()
			WHERE id = :id";

		// $sth = $dbh->prepare($sql);
		// $sth->bindvalue(':users', $newName);
		// $sth->execute();

		// $_SESSION['user'] = $newName;
	}
	//erreur présente donc...
	else{
		//rediriger avec un message d'erreur vers la page contenant le form
		echo $error;
	}
}
