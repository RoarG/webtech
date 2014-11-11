<?php
	$id = intval($_POST['id']);
	$name = strval($_POST['name']);
	$email = strval($_POST['email']);
	$latitude = floatval($_POST['lat']);
	$longitude = floatval($_POST['long']);
	$image = strval($_POST['image']);

	$db = mysqli_connect("mysql.stud.ntnu.no","audunasa_webtek","it2805","audunasa_prosjekt");

	if (!$db) {
		echo('Could not connect: ' . mysqli_error($db));
	}
	
	$query = "SELECT * FROM medlemmer
				WHERE id = ".$id.";";
	$result = mysqli_query($db, $query);
	
	if ($result != false) {
		$query = "INSERT INTO
				medlemmer (id, navn, email, breddegrad, lengdegrad, pris, bio, bildeURL)
				VALUES (".$id.",".$name.",".$email.",".$latitude.",".$longitude.",0,null,".$image.");";
		$result = mysqli_query($db, $query);
	} else {
		echo "Already exists in database!";
	}
	
	$db->close();	
?>