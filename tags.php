<?php

	include('config.php');
	include('db_connexion.php');
	include('vendor/autoload.php');


	for($i=0; $i<10; $i++){
		$faker = Faker\Factory::create();
		$name = $faker->text($maxNbChars = 100);
		

		$sql = "INSERT INTO tag(id, name, date_created, date_modified)
				VALUES (NULL, :name, NOW(), NOW())";
		$sth = $dbh->prepare($sql);
		$sth->bindValue(':name' , $name);
		$sth->execute();
	}
