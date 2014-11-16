<?php
	session_start();
	ini_set('display_errors',1);

	$id = strval($_POST['id']);
	$name = strval($_POST['name']);
	$email = strval($_POST['email']);
	$latitude = floatval($_POST['latitude']);
	$longitude = floatval($_POST['longitude']);
	$price = strval($_POST['price']);
	$bio = strval($_POST['bio']);
	$image = strval($_POST['image']);
	
	if ($name != null) {
		$name = "navn='".$name."',";
	} else {
		$name = "";
	}
	
	if ($email != null) {
		$email = "mail='".$email."'";
	} else {
		$email = "";
	}
	
	if ($latitude != null) {
		$latitude = "breddegrad='".$latitude."',";
	} else {
		$latitude = "";
	}
	
	if ($longitude != null) {
		$longitude = "lengdegrad='".$longitude."'";
	} else {
		$longitude = "";
	}
	
	if ($price != null) {
		$price = "pris='".$price."'";
	} else {
		$price = "";
	}
	
	if ($bio != null) {
		$bio = "bio='".$bio."'";
	} else {
		$bio = "";
	}
	
	$db = new mysqli("66.147.244.100:3306", "roargcom_audun", "it2805", "roargcom_webtek");

	if (!$db) {
		echo('Could not connect: ' . mysqli_error($db));
	}
	
	$query = "UPDATE medlemmer
				SET ".$name." ".$email." ".$latitude." ".$longitude." ".$price." ".$bio."
				WHERE id = '".$id."';";
	
	echo($query);
	
	$result = mysqli_query($db, $query);
	
	if (!$result) {
		echo('Could not update db, '.mysqli_error($db));
	} else {
		echo('Updated db!');
	}
	
	$db->close();
?>