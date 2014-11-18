<?php
	ini_set('display_errors',1);
	
	$userId = intval($_GET['id']);
	
	$db = new mysqli("localhost", "roargcom_audun", "it2805", "roargcom_webtek");
	
	if (!$db) {
		echo('Could not connect: ' . mysqli_error($db));
	}
	
	$query = "SELECT breddegrad, lengdegrad FROM medlemmer WHERE id='".$userId."';";

	$result = mysqli_query($db, $query);
	
	if (!$result) {
		printf("Error: %s\n", mysqli_error($db));
		exit();
	}
	
	$xml = new DOMDocument('1.0', 'utf-8');
	$xml->formatOutput = true;
	
	$root = $xml->createElement("root");
	$xml->appendChild($root);
	
	while($row = mysqli_fetch_array($result)){
		$info = $xml->createElement("info");
	
		$breddegrad = $xml->createElement("breddegrad");
		$breddegrad->appendChild($xml->createTextNode($row['breddegrad']));
		$info->appendChild($breddegrad);
		
		$lengdegrad = $xml->createElement("lengdegrad");
		$lengdegrad->appendChild($xml->createTextNode($row['lengdegrad']));
		$info->appendChild($lengdegrad);
		
		$root->appendChild($info);
	}

	echo $xml->saveXML();
	
	mysqli_close($db);
?>