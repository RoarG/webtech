<?php
	session_start();
	ini_set('display_errors',1);

	$id = strval($_POST['id']);
	$name = strval($_POST['name']);
	$email = strval($_POST['email']);
	$latitude = floatval($_POST['latitude']);
	$longitude = floatval($_POST['longitude']);
	$image = strval($_POST['image']);
	
	$db = new mysqli("66.147.244.100:3306", "roargcom_audun", "it2805", "roargcom_webtek");

	if (!$db) {
		echo('Could not connect: ' . mysqli_error($db));
	}
	
	$query = "SELECT * FROM medlemmer
				WHERE id = '".$id."';";
	$result = mysqli_query($db, $query);
	
	if (!$result) {
		$query = "INSERT INTO
					medlemmer (id, navn, mail, breddegrad, lengdegrad, pris, bio, bildeURL)
					VALUES ('".$id."','".$name."','".$email."',".$latitude.",".$longitude.",0,null,'".$image."');";
		$result = mysqli_query($db, $query);
		
		if (!$result) {
			echo('Could not add to db, '.mysqli_error($db));
		}
	} else {
		echo('Already exists in database!');
	}
	
	$db->close();	
?>