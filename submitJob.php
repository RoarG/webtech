<?php
	/*TODO: kjoperId/brukerId, lengdegrad, breddegrad må hentes fra Facebook*/

	$date = strval($_POST['date']);
	$time = strval($_POST['time']);
	$worker = strval($_POST['worker']);
	
	$dateArray = explode(".", $date);
	$dateFormatted = "$dateArray[2]-$dateArray[1]-$dateArray[0] $time:00";
	
	/*TODO: kan lage et eget PHP-skript for tilkobling til databasen*/
	$db = mysqli_connect("mysql.stud.ntnu.no","audunasa_webtek","it2805","audunasa_prosjekt");
	//$db = myqsli_connect("localhost","roargcom_audun","it2805","roargcom_webtek");
	
	if (!$db) {
	  die('Could not connect: ' . mysqli_error($db));
	}
	
	/*Lagrer jobb*/
	
	$query ="INSERT INTO
			jobber (jobbId,kjoperId, selgerId, tidspunkt, breddegrad, lengdegrad, pris, varighet,kommentar, tilbakemelding, rating)
			VALUES (NULL,1,".$worker.",'".$dateFormatted."',
			NULL,NULL,NULL,NULL,NULL,NULL, 0);";
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));

	/*Lagrer notification
	LAST_INSERT_ID henter jobbId fra den nettopp insatte jobben*/
	
	$query2 = "INSERT INTO
				varslinger (varslingId, brukerId, jobbId, tidspunkt, lest)
				VALUES (NULL, 1, LAST_INSERT_ID(), NOW(), false );";
	
	$result2 = mysqli_query($db, $query2) or die(mysqli_error($db));
	
	$db->close();

?>