<?php

	include('config.php');
	include('db_connexion.php');
	include('vendor/autoload.php');
	include('fonctions.php');


	$sql = "SELECT id
			FROM tag
			WHERE current = 1";
	$sth = $dbh->prepare($sql);
	$sth->execute();

	$tags_id = $sth->fetch();

	foreach ($tags_id as $tag_id){
		echo $tag_id;
	}