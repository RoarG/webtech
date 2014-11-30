<!DOCTYPE html>
<html>
<head>
	<title>Fri Tid</title>
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
						<img src="./images/logo.jpg"  height="130" width="450" alt="logo">
					</a>
				</div>
				<div class="box">
					<span id="categoryImg">
					<button class="header-button" id="minside" onclick="location.href='./account.php'"> Min side </button>
					</span>
				</div>
				<div class="box">
					<button class="header-button" id="hjelp" onclick="location.href='./faq.html'"> Hjelp</button>
				</div>
				<div class="box">
					<button class="header-button" id="omsiden" onclick="location.href='./omsiden.html'"> Om siden </button>
				</div>
			</div>
			
			<div class="nav" id="nav">
				<div class="category" onclick="openCategoryPage('husarbeid')"> 
					<img src="./images/house4.png" alt="husarbeid">
					<a>Husarbeid</a>
				</div>
				<div class="category" onclick="openCategoryPage('personlig assistent')">
					<img src="./images/assistent.svg" alt="personlig assistent">
					<a>Personlig assistent</a>
				</div>
				<div class="category" onclick="openCategoryPage('handyman')">
					<img src="./images/flyttingbil.svg" alt="handyman">
					<a>Handyman</a>
				</div>
				<div class="category" onclick="openCategoryPage('annet')">
					<img src="./images/annet.svg" alt="annet">
					<a>Annet</a>
				</div>
				<div>
					<input type="checkbox" name="toggle" id="toggle" />
					<label for="toggle"></label>
				</div>
			</div>
			
			<?php
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
				
				$query = "SELECT * FROM medlemmer WHERE id = '".$id."';";
				$result = mysqli_query($db, $query);
				
				$firstname = "Mickey";
				$lastname = "Mouse";
				$image = "./images/forsidebilde.png";
				$bio = "EN LANG TEXT, nei dette er en litt mindre.";
				
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$name = explode(" ", $row["navn"]);
						$firstname = $name[0];
						$lastname = $name[1];
						$image = $row["bildeURL"];
						$bio = $row["bio"];
					}
				} else {
					echo "0 results";
				}
				
				$query = "SELECT * FROM kategori WHERE personId = '".$id."';";
				$result = mysqli_query($db, $query);
				
				$plenklipping = false;
				$vasking = false;
				$rydding = false;
				$snomaking = false;
				$lekser = false;
				$hund = false;
				$handling = false;
				$flytting = false;
				$ikea = false;
				$pchjelp = false;
				$bilderedigering = false;
				$diverse = false;
				
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						if ($row["navn"] == "Plenklipping") {
							$plenklipping = true;
						}
						if ($row["navn"] == "Vasking") {
							$vasking = true;
						}
						if ($row["navn"] == "Rydding") {
							$rydding = true;
						}
						if ($row["navn"] == "Snomaking") {
							$snomaking = true;
						}
						if ($row["navn"] == "Lekser") {
							$lekser = true;
						}
						if ($row["navn"] == "Ga tur med hunden") {
							$hund = true;
						}
						if ($row["navn"] == "Handling") {
							$handling = true;
						}
						if ($row["navn"] == "Flytting") {
							$flytting = true;
						}
						if ($row["navn"] == "Mobelsammensetting") {
							$ikea = true;
						}
						if ($row["navn"] == "PC-hjelp") {
							$pchjelp = true;
						}
						if ($row["navn"] == "Bilderedigering") {
							$bilderedigering = true;
						}
						if ($row["navn"] == "Diverse") {
							$diverse = true;
						}
					}
				} else {
					//echo "0 results";
				}
			?>
			
			<div class="account">
				<h3 id="accountHeader"> Din Konto</h3> 
				<span class="accountNav">

  					<button class="accountButton" onclick="location.href='account.php'">Konto</button>
  					<button class="accountButton" onclick="location.href='price.php'">Pris</button>
  					<button class="accountButton" onclick="location.href='notifications.php'">Varslinger</button>
  					<button class="accountButton" onclick="location.href='place.php'">Steder</button>
  					<button class="accountButton" onclick="location.href='info.php'">Synlig Profil</button>

				</span>

				<div class="accountView" id="accountView">
					<div id="imagename">
						<div class="form" id="nameform">
							<form action="demo_form.asp">
								First name: <input size="25" type="text" name="FirstName" value=<?php echo($firstname);?>><br>
								Last name: <input size="25" type="text" name="LastName" value=<?php echo($lastname);?>><br>
							</form>
						</div>

						<div class="image">
							<img src=<?php echo($image);?> id="accountImg" alt="brukerbilde">
						</div>
					</div>

					<div class="bio">
						<div class="about">OM:</div>
						<textarea rows="5" cols="75" name="bio"><?php echo($bio);?></textarea>
					</div>

					<div class="categoryCont">
					<form action="demo_form.asp">
						<div class="categoryspan">
							<label>
								<input type="checkbox" name="category" value="husarbeid" onclick="husarbeid();"><span>Husarbeid</span>
							</label>
						</div>
						<div class="categoryspan">
							<label>
								<input type="checkbox" name="category" value="Personlig Assistent" onclick="assistent();"><span>Personlig Assistent</span>
							</label>
						</div>
						<div class="categoryspan">
							<label>
								<input type="checkbox" name="category" value="Handyman" onclick="handyman();"><span>Handyman</span>
							</label>
						</div>
						<div class="categoryspan">
							<label>
								<input type="checkbox" name="category" value="Diverse" <?php if ($diverse == true) echo "checked='checked'"; ?>><span>Diverse</span>
							</label>
						</div>
					</form>
					<form action="demo_form.asp" name="subcategories">
					</form>
					</div>
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
				<div id="socialMedia" class="footerBox">
					<div id="facebook" class="socialMediaBox"><img id="facebookLogo" src="./images/fbblue.png" alt="facebook"></div>
					<div id="twitter" class="socialMediaBox"><img id="twitterLogo" src="https://g.twimg.com/Twitter_logo_blue.png" alt="twitter"></div>
					<div id="linkedin" class="socialMediaBox"><img id="linkedinLogo" src="./images/linkedIn.png" alt="linkedin"></div>
					<div id="google" class="socialMediaBox"><img id="googleLogo" src="./images/g+64.png" alt="google+"></div>
				</div>
				<div id="copyright" class="footerBox">
					<div id="copyrightSpan" class="copy"><p id="copyrightSymbol">&copy; </p></div> 
					<span id="names" class="copy">Roar Gjøvaag <br> 
					Runar Heggset <br> Audun Sæther</span>
				</div>
				
				<div id="logo" class="footerBox">
					<img id="footerLogo" src="./images/logo.jpg" alt="logo">
				</div>
			</div>
		</section>
		<script src="./js/slide.js"></script>
		<script src="./js/login.js"></script>
		<script>
			var plenklipping = <?php echo json_encode($plenklipping); ?>;
			var vasking = <?php echo json_encode($vasking); ?>;
			var rydding = <?php echo json_encode($rydding); ?>;
			var snomaking = <?php echo json_encode($snomaking); ?>;
			var lekser = <?php echo json_encode($lekser); ?>;
			var hund = <?php echo json_encode($hund); ?>;
			var handling = <?php echo json_encode($handling); ?>;
			var flytting = <?php echo json_encode($flytting); ?>;
			var ikea = <?php echo json_encode($ikea); ?>;
			var pchjelp = <?php echo json_encode($pchjelp); ?>;
			var bilderedigering = <?php echo json_encode($bilderedigering); ?>;
			var diverse = <?php echo json_encode($diverse); ?>;
		
			function updateDatabase() {
				var id = parseInt(getCookie("userId"));
				var first = document.getElementsByName("FirstName")[0].value;
				var last = document.getElementsByName("LastName")[0].value;
				var bio = document.getElementsByName("bio")[0].value;
				var diverse2 = document.getElementsByName("category")[3].checked;
					
				var params = "id="+id+"&name="+first+" "+last+"&bio="+bio+
							"&plenklipping="+plenklipping+"&vasking="+vasking+"&snomaking="+snomaking+"&lekser="+lekser+
							"&hund="+hund+"&handling="+handling+"&flytting="+flytting+"&ikea="+ikea+
							"&pchjelp="+pchjelp+"&bilderedigering="+bilderedigering+"&diverse="+diverse2+"&rydding="+rydding;
				
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
			
			function clearSubcategories() {
				var form = document.getElementsByName("subcategories")[0];
				while(form.firstChild){
					form.removeChild(form.firstChild);
				}
			}
					
			function husarbeid() {
				clearSubcategories();
				document.getElementsByName("category")[1].checked = false;
				document.getElementsByName("category")[2].checked = false;
				var button = document.getElementsByName("category")[0].checked;
				if (button == true) {
					var form = document.getElementsByName("subcategories")[0];
					
					var div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
							
					var label = document.createElement("label");
					var input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "plenklipping";
					input.checked = plenklipping;
					input.onclick = function() { 
						plenklipping = !plenklipping;
					};
					var span = document.createElement("span");
					span.innerHTML = "Plenklipping";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
							
					div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
						
					label = document.createElement("label");
					input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "vasking";
					input.checked = vasking;
					input.onclick = function() { 
						vasking = !vasking;
					};
					span = document.createElement("span");
					span.innerHTML = "Vasking";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
							
					div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
							
					label = document.createElement("label");
					input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "rydding";
					input.checked = rydding;
					input.onclick = function() { 
						rydding = !rydding;
					};
					span = document.createElement("span");
					span.innerHTML = "Rydding";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
							
					div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
							
					label = document.createElement("label");
					input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "snømåking";
					input.checked = snomaking;
					input.onclick = function() { 
						snomaking = !snomaking;
					};
					span = document.createElement("span");
					span.innerHTML = "Snømåking";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
				}
			}

			function assistent() {
				clearSubcategories();
				document.getElementsByName("category")[0].checked = false;
				document.getElementsByName("category")[2].checked = false;
				var button = document.getElementsByName("category")[1].checked;
				if (button == true) {
					var form = document.getElementsByName("subcategories")[0];
					
					var div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
							
					var label = document.createElement("label");
					var input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "lekser";
					input.checked = lekser;
					input.onclick = function() { 
						lekser = !lekser;
					};
					var span = document.createElement("span");
					span.innerHTML = "Lekser";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
							
					div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
						
					label = document.createElement("label");
					input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "hund";
					input.checked = hund;
					input.onclick = function() { 
						hund = !hund;
					};
					span = document.createElement("span");
					span.innerHTML = "Gå tur med hunden";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
							
					div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
							
					label = document.createElement("label");
					input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "handling";
					input.checked = handling;
					input.onclick = function() { 
						handling = !handling;
					};
					span = document.createElement("span");
					span.innerHTML = "Handling";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
				}
			}

			function handyman() {
				clearSubcategories();
				document.getElementsByName("category")[1].checked = false;
				document.getElementsByName("category")[0].checked = false;
				var button = document.getElementsByName("category")[2].checked;
				if (button == true) {
					var form = document.getElementsByName("subcategories")[0];
					
					var div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
							
					var label = document.createElement("label");
					var input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "flytting";
					input.checked = flytting;
					input.onclick = function() { 
						flytting = !flytting;
					};
					var span = document.createElement("span");
					span.innerHTML = "Flytting";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
							
					div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
						
					label = document.createElement("label");
					input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "ikea";
					input.checked = ikea;
					input.onclick = function() { 
						ikea = !ikea;
					};
					span = document.createElement("span");
					span.innerHTML = "Møbelsammensetting";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
							
					div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
							
					label = document.createElement("label");
					input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "pchjelp";
					input.checked = pchjelp;
					input.onclick = function() { 
						pchjelp = !pchjelp;
					};
					span = document.createElement("span");
					span.innerHTML = "PC-hjelp";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
					
					div = document.createElement("div");
					div.className = "categoryspan";
					div.name = "subcategory";
							
					label = document.createElement("label");
					input = document.createElement("input");
					input.type = "checkbox";
					input.name = "category";
					input.value = "bilderedigering";
					input.checked = bilderedigering;
					input.onclick = function() { 
						bilderedigering = !bilderedigering;
					};
					span = document.createElement("span");
					span.innerHTML = "Bilderedigering";
							
					label.appendChild(input);
					label.appendChild(span);
					div.appendChild(label);
					form.appendChild(div);
				}
			}
		</script>

</body>
</html>