<?php
	ini_set('display_errors',1);
		
	$cat = strval($_GET['cat']);
	$lat = strval($_GET['lat']);
	$long = strval($_GET['long']);
	
	//$db = mysqli_connect("mysql.stud.ntnu.no","audunasa_webtek","it2805","audunasa_prosjekt");
	$db = myqsli_connect("localhost","roargcom_audun","it2805","roargcom_webtek");
		
	if (!$db) {
	  echo('Could not connect: ' . mysqli_error($db));
	}
	
	$query = "SELECT id,m.navn AS navn,bildeURL, breddegrad, lengdegrad, bio, ifnull(m2.r,0) as rating,
			ROUND((6371 * ACOS( COS( RADIANS(".$lat.") ) * COS( RADIANS(breddegrad) ) 
			* COS( RADIANS(".$long.") - RADIANS(lengdegrad) ) + 
			SIN( RADIANS(".$lat.") ) * SIN( RADIANS(breddegrad) ) ) ),2) AS avstand
			FROM medlemmer AS m 
			LEFT JOIN kategori AS c ON m.id=c.personId
			LEFT JOIN (SELECT selgerId, avg(rating) as r
						FROM jobber
						GROUP BY selgerId) AS m2 on m2.selgerId=m.id
			WHERE c.navn='".$cat."'
			HAVING avstand<100
			ORDER BY avstand;";
	
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
		
		$breddegrad = $xml->createElement("breddegrad");
		$breddegrad->appendChild($xml->createTextNode($row['breddegrad']));
		$person->appendChild($breddegrad);
		
		$lengdegrad = $xml->createElement("lengdegrad");
		$lengdegrad->appendChild($xml->createTextNode($row['lengdegrad']));
		$person->appendChild($lengdegrad);
				
		$avstand = $xml->createElement("avstand");
		$avstand->appendChild($xml->createTextNode($row['avstand']));
		$person->appendChild($avstand);
		
		$navn = $xml->createElement("navn");
		$navn->appendChild($xml->createTextNode($row['navn']));
		$person->appendChild($navn);
		
		$rating = $xml->createElement("rating");
		$rating->appendChild($xml->createTextNode($row['rating']));
		$person->appendChild($rating);
		
		$bilde = $xml->createElement("bilde");
		$bilde->appendChild($xml->createTextNode($row['bildeURL']));
		$person->appendChild($bilde);
		
		$root->appendChild($person);
	}

	echo $xml->saveXML();
	
	
	mysqli_close($db);
?>
