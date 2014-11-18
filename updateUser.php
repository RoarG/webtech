<?php
	session_start();

	$id = strval($_POST['id']);
	$name = strval($_POST['name']);
	$email = strval($_POST['email']);
	$latitude = floatval($_POST['latitude']);
	$longitude = floatval($_POST['longitude']);
	$price = strval($_POST['price']);
	$bio = strval($_POST['bio']);
	$image = strval($_POST['image']);
	$husarb = $_POST['husarb'];
	$assistent = $_POST['assistent'];
	$handyman = $_POST['handyman'];
	$diverse = $_POST['diverse'];
	
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
	
	$db = new mysqli("localhost", "roargcom_audun", "it2805", "roargcom_webtek");

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
	
	if ($husarb != null) {
		if ($husarb == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Husarbeid');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Husarbeid';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($assistent != null) {
		if ($assistent == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Personlig Assistent');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Personlig Assistent';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($handyman != null) {
		if ($handyman == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Handyman');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Handyman';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($diverse != null) {
		if ($diverse == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Diverse');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Diverse';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	$db->close();
?>