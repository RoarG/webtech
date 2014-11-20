<?php
	ini_set('display_errors',1);
	
	$id = strval($_POST['id']);
	$date = strval($_POST['date']);
	$time = strval($_POST['time']);
	$worker = strval($_POST['worker']);
	$category = strval($_POST['cat']);
	
	$dateArray = explode(".", $date);
	$dateFormatted = "$dateArray[2]-$dateArray[1]-$dateArray[0] $time:00";
	
	//$db = mysqli_connect("mysql.stud.ntnu.no","audunasa_webtek","it2805","audunasa_prosjekt");
	$db = new mysqli("localhost","roargcom_audun","it2805","roargcom_webtek");
	
	if (!$db) {
	  die('Could not connect: ' . mysqli_error($db));
	}
	
	/*Lagrer jobb*/
	
	$query ="INSERT INTO
			jobber (jobbId,kjoperId, selgerId, tidspunkt, breddegrad, lengdegrad, pris, varighet,kommentar, tilbakemelding, rating, kategorinavn)
			VALUES (NULL,'".$id."','".$worker."','".$dateFormatted."',
			NULL,NULL,NULL,NULL,NULL,NULL, NULL, '".$category."');";
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));

	/*Lagrer notification
	LAST_INSERT_ID henter jobbId fra den nettopp insatte jobben*/
	
	$query2 = "INSERT INTO
				varslinger (varslingId, brukerId, jobbId, tidspunkt, lest)
				VALUES (NULL, 1, LAST_INSERT_ID(), NOW(), false );";
	
	$result2 = mysqli_query($db, $query2) or die(mysqli_error($db));
	
	$db->close();

?>