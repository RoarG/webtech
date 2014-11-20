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
	
	$plenklipping = $_POST['plenklipping'];
	$vasking = $_POST['vasking'];
	$rydding = $_POST['rydding'];
	$snomaking = $_POST['snomaking'];
	$lekser = $_POST['lekser'];
	$hund = $_POST['hund'];
	$handling = $_POST['handling'];
	$flytting = $_POST['flytting'];
	$ikea = $_POST['ikea'];
	$pchjelp = $_POST['pchjelp'];
	$bilderedigering = $_POST['bilderedigering'];
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
	
	if ($plenklipping != null) {
		if ($plenklipping == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Plenklipping');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Plenklipping';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($vasking != null) {
		if ($vasking == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Vasking');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Vasking';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($rydding != null) {
		if ($rydding == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Rydding');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Rydding';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($snomaking != null) {
		if ($snomaking == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Snomaking');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Snomaking';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($lekser != null) {
		if ($lekser == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Lekser');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Lekser';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($hund != null) {
		if ($hund == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Ga tur med hunden');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Ga tur med hunden';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($handling != null) {
		if ($handling == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Handling');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Handling';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($flytting != null) {
		if ($flytting == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Flytting');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Flytting';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($ikea != null) {
		if ($ikea == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Mobelsammensetting');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Mobelsammensetting';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($pchjelp != null) {
		if ($pchjelp == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'PC-hjelp');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='PC-hjelp';";
			$result = mysqli_query($db, $query);
		}
		if (!$result) {
			echo('Could not update db, '.mysqli_error($db));
		} else {
			echo('Updated db!');
		}
	}
	
	if ($bilderedigering != null) {
		if ($bilderedigering == "true") {
			$query = "INSERT INTO kategori (personId, navn) VALUES ('".$id."', 'Bilderedigering');";
			$result = mysqli_query($db, $query);
		} else {
			$query = "DELETE FROM kategori WHERE personId='".$id."' AND navn='Bilderedigering';";
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