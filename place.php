<!DOCTYPE html>
<html>
<head>
	<title>Account Side</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/account.css">
	<meta charset="UTF-8">
</head>
<body>
			<section class="page">
			<div class="header">
				<div class="login">
					<div class="loginId">
						<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
						</fb:login-button>
					</div>
					<div class="loginId">
						<div id="name">
						</div>
					</div>
				</div>
				<div class="logo">
					<a href="./index.html">
						<img src="./images/logo.png" />
					</a>
				</div>
				<div class="box">
					<span id="categoryImg">
					<button class="header-button" id="minside" onclick="location.href='./account.php'"> Min Side </button>
					</span>
				</div>
				<div class="box">
					<button class="header-button" id="hjelp" onclick="location.href='./faq.html'"> Hjelp</button>
				</div>
				<div class="box">
					<button class="header-button" id="omsiden" onclick="location.href='./omsiden.html'"> Om Siden </button>
				</div>
			</div>
			
			<div class="nav" id="nav">
				<div class="category" onclick="openCategoryPage('husarbeid')"> 
					<img src="./images/house4.png">
					<a>Husarbeid</a>
				</div>
				<div class="category" onclick="openCategoryPage('personlig assistent')">
					<img src="./images/assistent.svg">
					<a>Personlig assistent</a>
				</div>
				<div class="category" onclick="openCategoryPage('handyman')">
					<img src="./images/flyttingbil.svg">
					<a>Handyman</a>
				</div>
				<div class="category" onclick="openCategoryPage('annet')">
					<img src="./images/annet.svg">
					<a>Annet</a>
				</div>
				<div>
					<input type="checkbox" name="toggle" id="toggle" />
					<label for="toggle"></label>
				</div>
			</div>
			
			<?php
				ini_set('display_errors',1);
				
				$id = "0";
				$cookie_name = "userId";
				if(isset($_COOKIE[$cookie_name])) {
					$id = $_COOKIE[$cookie_name];
				} else {
					header("Location: ./index.html");
					die();
				}
				
				$db = new mysqli("localhost", "roargcom_audun", "it2805", "roargcom_webtek");

				if (!$db) {
					echo('Could not connect: ' . mysqli_error($db));
				}
				
				$query = "SELECT * FROM medlemmer
							WHERE id = '".$id."';";
				$result = mysqli_query($db, $query);
				
				$lat = 63.41;
				$lng = 10.44;
				
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$lat = $row["breddegrad"];
						$lng = $row["lengdegrad"];
					}
				} else {
					echo "0 results";
				}
			?>
			
			<div class="coords" style="display: none;">
				<p id="lat"><?php echo($lat);?>></p>
				<p id="lng"><?php echo($lng);?></p>
			</div>
			
			<div class="account">
				<h3 id="accountHeader"> Din Konto</h3> 
				<span class="accountNav">
<<<<<<< HEAD
  					<button class="button" id="accountButton" onclick="location.href='account.php'">Konto</button>
  					<button class="button" id="accountButton" onclick="location.href='price.php'">Pris</button>
  					<button class="button" id="accountButton" onclick="location.href='notifications.php'">Varslinger</button>
  					<button class="button" id="accountButton" onclick="location.href='place.php'">Steder</button>
  					<button class="button" id="accountButton" onclick="location.href='info.html'">Kontakt</button>
=======
  					<button class="button" onclick="location.href='account.php'">Konto</button>
  					<button class="button" onclick="location.href='price.php'">Pris</button>
  					<button class="button" onclick="location.href='notifications.php'">Varslinger</button>
  					<button class="button" onclick="location.href='place.php'">Steder</button>
  					<button class="button" onclick="location.href='info.php'">Kontakt</button>
>>>>>>> da5ee456cfeca8fb772c6cdc417f0b44b678e0d8
				</span>

				<div class="accountView" id="accountView">
					<div class="name">
						STED
					</div>

					<div class="summary">
						<div id="map" class="inputbox" >
							<h3 id="mapHeader" class="inputHeader">Velg et utgangspunkt for ditt arbeidsområde ved å trykke på kartet</h3>
							<!--<input id="search" type="text" placeholder="Skriv inn din adresse">-->
							<div id="map-canvas"></div>
						</div>
						
						<h4 id="radiusHeader" class="inputHeader">Velg radius for ditt arbeidsområde</h4>
						<input type="range" id="radiusSlider" min="0" max="100" value="0" step="1" onchange="setCircleRadius(this.value)"/>
						<span id="range">0</span><br>
						
						<button class="button" onclick="updateDatabase();">Lagre</button>
					</div>
			</div>
						
			<div class="footer">
				<div id="contact" class="footerBox">
					<h4 class="footerHeader">Kontakt oss</h4>
					
					<form id="contactForm">
						<h5 class="contactFormHeader">Navn: </h5>
						<input class="contactFormElement" type="text" name="senderName" required>
						<h5 class="contactFormHeader">Mailadresse: </h5>
						<input class="contactFormElement" type="email" name="senderMail" required>
						<h5 class="contactFormHeader">Melding: </h5>
						<textarea class="contactFormElement" id="comment" name="textarea" required ></textarea>
						<input type="submit" id="sendMessageButton" value="Send melding">
					</form>
					
				</div>
				<div id="divLinks" class="footerBox">
					<h4 class="footerHeader">Linker</h4><br><br>
					<a href="./siteMap.html">Site map</a><br><br>
					<a href="./references.html">Referanser</a>
				</div>
				<div id="copyright" class="footerBox">
					<span id="copyrightSpan" class="copy"><p id="copyrightSymbol">&copy; </p></span> 
					<span id="names" class="copy">Roar Gjøvaag <br> 
					Runar Heggset <br> Audun Sæther</span>
				</div>
				<div id="logo" class="footerBox">
					<img id="footerLogo" src="./images/logo.png"></img>
				</div>
			</div>
		</section>
	<script src="./js/map.js"></script>
	<script src="lib/jquery-2.1.1.min.js"></script>
	<script src="./js/slide.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="./js/login.js"></script>
	<script>
		function updateDatabase() {
			var id = parseInt(getCookie("userId"));
			var lat = marker.getPosition().lat();
			var lng = marker.getPosition().lng();
			
			var params = "id="+id+"&latitude="+lat+"&longitude="+lng;
				
			xmlhttp = new XMLHttpRequest();	
			xmlhttp.open("POST", "updateUser.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send(params);
		}
			
		function getCookie(cname) {
			var name = cname + "=";
			var ca = document.cookie.split(';');
			for(var i=0; i<ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1);
				if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
			}
			return "";
		}
		</script>
</body>
</html>