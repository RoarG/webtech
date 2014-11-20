<?php
	ini_set('display_errors',1);
	
	//$db = mysqli_connect("mysql.stud.ntnu.no","audunasa_webtek","it2805","audunasa_prosjekt");
	$db = new mysqli("localhost","roargcom_audun","it2805","roargcom_webtek");
		
	if (!$db) {
	  echo('Could not connect: ' . mysqli_error($db));
	}
	
	$query = "SELECT id,navn,bildeURL,ifnull(m2.s,0) as jobber, ifnull(m2.r,0) as rating
			FROM medlemmer AS m 
			LEFT JOIN (SELECT selgerId, count(*) as s, avg(rating) as r
						FROM jobber
						GROUP BY selgerId) AS m2 on m2.selgerId=m.id
			ORDER BY rating DESC, jobber
			LIMIT 6;";
	
	$result = mysqli_query($db, $query);

	
	if (!$result) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
	
	$xml = new DOMDocument('1.0', 'utf-8');
	$xml->formatOutput = true;
	
	$root = $xml->createElement("workers");
	$xml->appendChild($root);
	
	while($row = mysqli_fetch_array($result)){
		$person = $xml->createElement("person");
		
		$id = $xml->createElement("id");
		$id->appendChild($xml->createTextNode($row['id']));
		$person->appendChild($id);
				
		$bilde = $xml->createElement("bilde");
		$bilde->appendChild($xml->createTextNode($row['bildeURL']));
		$person->appendChild($bilde);
		
		$navn = $xml->createElement("navn");
		$navn->appendChild($xml->createTextNode($row['navn']));
		$person->appendChild($navn);
		
		$rating = $xml->createElement("rating");
		$rating->appendChild($xml->createTextNode($row['rating']));
		$person->appendChild($rating);
		
		$numJobs = $xml->createElement("antall");
		$numJobs->appendChild($xml->createTextNode($row['jobber']));
		$person->appendChild($numJobs);
		
		$root->appendChild($person);
	}

	echo $xml->saveXML();
	
	
	mysqli_close($db);
?>
