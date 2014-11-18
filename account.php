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
				
				$db = new mysqli("66.147.244.100:3306", "roargcom_audun", "it2805", "roargcom_webtek");

				if (!$db) {
					echo('Could not connect: ' . mysqli_error($db));
				}
				
				$query = "SELECT * FROM medlemmer
							WHERE id = '".$id."';";
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
			?>
			
			<div class="account">
				<h3 id="accountHeader"> Din Konto</h3> 
				<span class="accountNav">
  					<button class="button" id="accountButton" onclick="location.href='account.php'">Konto</button>
  					<button class="button" id="accountButton" onclick="location.href='price.php'">Pris</button>
  					<button class="button" id="accountButton" onclick="location.href='notifications.php'">Varslinger</button>
  					<button class="button" id="accountButton" onclick="location.href='place.php'">Steder</button>
  					<button class="button" id="accountButton" onclick="location.href='info.html'">Synlig Profil</button>
				</span>

				<div class="accountView" id="accountView">
					<div id="imagename">
						<div class="form" id="nameform">
							<form action="demo_form.asp">
								First name: <input id="namform" size="25" type="text" name="FirstName" value=<?php echo($firstname);?>><br>
								Last name: <input id="namform" size="25" type="text" name="LastName" value=<?php echo($lastname);?>><br>
							</form>
						</div>

						<div class="image" id="accountImg">
							<img src=<?php echo($image);?> id="accountImg"></img>
						</div>
					</div>

					<div class="bio">
						<div class="about">OM:</div>
						<textarea rows="5" cols="75" name="bio"><?php echo($bio);?></textarea>
					</div>
					<div class="categoryCont">
						<div id="categoryspan">
							<label>
								<input type="checkbox" name="category" value="husarbeid"><span>Husarbeid</span>
							</label>
						</div>
						<div id="categoryspan">
							<label>
								<input type="checkbox" name="category" value="Personlig Assistent"><span>Personlig Assistent</span>
							</label>
						</div>
						<div id="categoryspan">
							<label>
								<input type="checkbox" name="category" value="Handyman"><span>Husarbeid</span>
							</label>
						</div>
						<div id="categoryspan">
							<label>
								<input type="checkbox" name="category" value="Diverse"><span>Diverse</span>
							</label>
						</div>
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
		<script src="./js/slide.js"></script>
		
		<script>
		
		function updateDatabase() {
			var id = parseInt(getCookie("userId"));
			var first = document.getElementsByName("FirstName")[0].value;
			var last = document.getElementsByName("LastName")[0].value;
			var bio = document.getElementsByName("bio")[0].value;
		
			var params = "id="+id+"&name="+first+" "+last+"&bio="+bio;
			
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