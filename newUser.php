<?php
	session_start();
	ini_set('display_errors',1);

	$id = strval($_POST['id']);
	$name = strval($_POST['name']);
	$email = strval($_POST['email']);
	$latitude = floatval($_POST['latitude']);
	$longitude = floatval($_POST['longitude']);
	$image = strval($_POST['image']);
	
	$db = new mysqli("localhost", "roargcom_audun", "it2805", "roargcom_webtek");

	if (!$db) {
		echo('Could not connect: ' . mysqli_error($db));
	}
	
	$query = "INSERT INTO
				medlemmer (id, navn, mail,sms, breddegrad, lengdegrad, radius, pris, betalingsform, bio, bildeURL)
				VALUES ('".$id."','".$name."','".$email."',null,".$latitude.",".$longitude.",0,0,null,null,'".$image."');";
	$result = mysqli_query($db, $query);
		
	if (!$result) {
		echo('Could not add to db, already exists? '.mysqli_error($db));
	} else {
		echo('Added user with id ' .$id);
	}
	
	$db->close();	
?>