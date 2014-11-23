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
						<img src="./images/logo.jpg"  height="130" width="450" />
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
				
				$email = "";
				
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$email = $row["mail"];
					}
				} else {
					echo "0 results";
				}
				
				$query2 = "SELECT * 
							FROM jobber as j
							LEFT JOIN (SELECT id, navn FROM medlemmer) as m on m.id=j.kjoperId
							WHERE j.selgerId='".$id."'
							ORDER BY jobbId DESC
							LIMIT 5;";
				
				$receivedNotes = mysqli_query($db, $query2);
				
				$rNotes = array();
				
				if ($receivedNotes->num_rows > 0) {
					while($row = $receivedNotes->fetch_assoc()) {
						$job[] = array();
						$job['buyer'] = $row['navn'];
						$job['jobtime'] = $row['tidspunkt'];
						$job['category'] = $row['kategorinavn'];
						$rNotes[] = $job;
					}
				} else {
					//echo "0 results";
				}
							
				$query3 = "SELECT * 
							FROM jobber as j 
							LEFT JOIN (SELECT id,navn FROM medlemmer) as m on m.id=j.selgerId
							WHERE j.kjoperId='".$id."'
							ORDER BY jobbId DESC
							LIMIT 5;";
				
				$sentNotes = mysqli_query($db, $query3);
				
				$sNotes = array();
				
				if ($sentNotes->num_rows > 0) {
					while($row = $sentNotes->fetch_assoc()) {
						$sjob[] = array();
						$sjob['seller'] = $row['navn'];
						$sjob['jobtime'] = $row['tidspunkt'];
						$sjob['category'] = $row['kategorinavn'];
						$sNotes[] = $sjob;
					}
				} else {
					//echo "0 results";
				}
				
			?>
			
			<div class="account">
				<h3 id="accountHeader"> Din Konto</h3> 
				<span class="accountNav">

  					<button class="button" id="accountButton" onclick="location.href='account.php'">Konto</button>
  					<button class="button" id="accountButton" onclick="location.href='price.php'">Pris</button>
  					<button class="button" id="accountButton" onclick="location.href='notifications.php'">Varslinger</button>
  					<button class="button" id="accountButton" onclick="location.href='place.php'">Steder</button>
  					<button class="button" id="accountButton" onclick="location.href='info.php'">Synlig profil</button>

				</span>

				<div class="accountView" id="accountView">
					<div class="accountCont">
						Varslinger
					</div>

					<div class="summary">
						<form action="">
						<input type="checkbox" name="Mail" value="mail">Motta oppdatteringer på E-Post
						<input type="text" name="emailtext" value=<?php echo($email);?>><br>
						<input type="checkbox" name="Sms" value="sms">Motta  oppdateringer på Sms<input type="text">
						</form>
						
						<button class="button" onclick="updateDatabase();">Lagre</button>
					</div>
					
					<div class="noteBox">
						<h4 class="noteHeader">De 5 siste innkommende varslinger</h4>
						<div id="receivedNotes" class="notifications">
							<?php
							if(count($rNotes)>0){
								for($x=0; $x<count($rNotes); $x++){
									echo ($rNotes[$x]['buyer']);
									echo " sendte deg en jobbforespørsel i kategorien ";
									echo ($rNotes[$x]['category']);
									echo " for utførelse ";
									echo ($rNotes[$x]['jobtime']);
									echo "<br><hr>";
								}
							}
							else {
								echo "Ingen har sendt jobbforespørsel til deg";
							}
							?>
						</div>
					</div> 
					<div class="noteBox">
						<h4 class="noteHeader">De 5 siste utsendte varslinger</h4>
						<div id="sentNotes" class="notifications">
							<?php
							if(count($sNotes)>0){
								for($x=0; $x<count($sNotes); $x++){
									echo "Du sendte en jobbforespørsel til ";
									echo ($sNotes[$x]['seller']);
									echo " om å utføre jobb i kategorien ";
									echo ($sNotes[$x]['category']);
									echo " ";
									echo ($sNotes[$x]['jobtime']);
									echo "<br><hr>";
								}
							}else {
								echo "Du har ikke send noen jobbforepørsler ennå!";
							}
							?>
						</div>
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
					<div id="facebook" class="socialMediaBox"><img id="facebookLogo" src="./images/fbblue.png"></div>
					<div id="twitter" class="socialMediaBox"><img id="twitterLogo" src="https://g.twimg.com/Twitter_logo_blue.png"></div>
					<div id="linkedin" class="socialMediaBox"><img id="linkedinLogo" src="./images/linkedIn.png"></div>
					<div id="google" class="socialMediaBox"><img id="googleLogo" src="./images/g+64.png"></div>
				</div>
				<div id="copyright" class="footerBox">
					<span id="copyrightSpan" class="copy"><p id="copyrightSymbol">&copy; </p></span> 
					<span id="names" class="copy">Roar Gjøvaag <br> 
					Runar Heggset <br> Audun Sæther</span>
				</div>
				
				<div id="logo" class="footerBox">
					<img id="footerLogo" src="./images/logo.jpg"></img>
				</div>
			</div>
		</section>
		<script src="./js/slide.js"></script>
		<script src="./js/login.js"></script>
		<script>
		
		function updateDatabase() {
			var id = parseInt(getCookie("userId"));
			var email = document.getElementsByName("emailtext")[0].value;
		
			var params = "id="+id+"&email="+email;
			
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