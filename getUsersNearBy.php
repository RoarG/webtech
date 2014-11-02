<?php
	ini_set('display_errors',1);
		
	$q = strval($_GET['q']);
	
	$db = mysqli_connect("mysql.stud.ntnu.no","audunasa_webtek","it2805","audunasa_prosjekt");

	if (!$db) {
	  die('Could not connect: ' . mysqli_error($db));
	}
	
	$result = mysqli_query($db, "SELECT m.id,m.breddegrad, m.lengdegrad,bio
								FROM members AS m LEFT JOIN category AS c ON m.id=c.personID
								WHERE c.navn='".$q."';");
	
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
		
		$bio = $xml->createElement("bio");
		$bio->appendChild($xml->createTextNode($row['bio']));
		$person->appendChild($bio);
		
		$root->appendChild($person);
	}

	echo $xml->saveXML();
	
	
	mysqli_close($db);
?>
