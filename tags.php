<?php

	include('config.php');
	include('db_connexion.php');
	include('vendor/autoload.php');
	include('fonctions.php');


	// for($i=0; $i<1; $i++){
	// 	$faker = Faker\Factory::create();
	// 	$name = $faker->text($maxNbChars = 100);
		

	// 	$sql = "INSERT INTO tag(id, name, date_created, date_modified)
	// 			VALUES (NULL, :name, NOW(), NOW())";
	// 	$sth = $dbh->prepare($sql);
	// 	$sth->bindValue(':name' , $name);
	// 	$sth->execute();
	// }

	
	$sql = "SELECT name 
			FROM tag
			WHERE current = 1";
	$sth = $dbh->prepare($sql);
	$sth->execute();

	$tags = $sth->fetch();

	// pr($tags);
	
	foreach ($tags as $tag) {
			echo $tag;
		}
	
	

	

		
	

	$sql = "SELECT tweets.messages, tag.name
			FROM tweets
			LEFT JOIN tag
			ON tweets.tag_id = tag.id";
	$sth = $dbh->prepare($sql);
	$sth->execute();







	
