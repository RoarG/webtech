<!DOCTYPE html>
<html>
<head>
	<title>Account Side</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/account.css">
	<meta charset="UTF-8">
	<style>
		#userInfo{
			margin-top: 20px;
		}
	
		.infoBox{
			text-align: center;
			width: 300px;
			margin-left: 280px;
			padding: 20px;
			float: left;
			background-color: #DFDDDA;
			border-bottom: 1px solid grey;
		}
	</style>
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
								
				//$db = mysqli_connect("mysql.stud.ntnu.no","audunasa_webtek","it2805","audunasa_prosjekt");
				$db = new mysqli("localhost", "roargcom_audun", "it2805", "roargcom_webtek");

				if (!$db) {
					echo('Could not connect: ' . mysqli_error($db));
				}
				
				//Må hente id fra et sted
				$id = 1497403270535912;
				
				$query = "SELECT * FROM medlemmer
							WHERE id = '".$id."';";
				$result = mysqli_query($db, $query);
				
				$name = "";
				$image = "";
				$rating = "";
				$bio = "";
				$categories = "";
				
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$name = $row['navn'];
						$email = $row["mail"];
						$bio = $row['bio'];
						$image = $row['bildeURL'];
					}
				} else {
					echo "0 results";
				}
				
				$query2 = "SELECT selgerId, avg(rating) as rating
						FROM jobber
						WHERE selgerId='".$id."'
						GROUP BY selgerId;";
				
				$result2 = mysqli_query($db, $query2);
				
				if ($result2->num_rows > 0) {
					while($row = $result2->fetch_assoc()) {
						$rating = $row['rating'];
					}
				} else {
					echo "0 results for rating";
				}
				
				$query3 = "SELECT navn FROM kategori WHERE personId='".$id."';";

				$result3 = mysqli_query($db, $query3);
				
				if ($result3->num_rows > 0) {
					while($row = $result3->fetch_assoc()) {
						$categories[] = $row['navn'];
					}
				} else {
					echo "0 results for kategori";
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
					<div id="userInfo">
						<div id="userName" class="infoBox"><? echo($name);?></div>
						<div id="userImage" class="infoBox"><img src=<?php echo($image);?> id="accountImg"></img></div>
						
						<div id="userRating" class="infoBox">
							<div class="starRating" id="ratingDiv">
							  <div>
								<div>
								  <div>
									<div>
									  <input id="rating1" type="radio" name="rating" value="1">
									  <label for="rating1"><span>1</span></label>
									</div>
									<input id="rating2" type="radio" name="rating" value="2">
									<label for="rating2"><span>2</span></label>
								  </div>
								  <input id="rating3" type="radio" name="rating" value="3">
								  <label for="rating3"><span>3</span></label>
								</div>
								<input id="rating4" type="radio" name="rating" value="4">
								<label for="rating4"><span>4</span></label>
							  </div>
							  <input id="rating5" type="radio" name="rating" value="5">
							  <label for="rating5"><span>5</span></label>
							</div>
						</div>
					</div>
					<script>
						var labels = document.getElementById('ratingDiv').getElementsByTagName('label');
						for (var i=0; i<Math.ceil(<? echo($rating);?>); i++){
							labels[i].style.background = "url('stars.png') repeat-x 0 -24px";
						}		
					</script>
				
				<div id="userBio" class="infoBox">Om <? echo($name);?> :<br><br> <? echo($bio);?></div>
				
				<div id="userCategories" class="infoBox">Tar jobber i kategoriene:<br><br> 
				<? if(count($categories)>0){
				for ($x=0; $x <count($categories); $x++){echo($categories[$x]);echo('<br>');}}
				?></div>
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
					<img id="footerLogo" src="./images/logo.jpg"></img>
				</div>
			</div>
		</section>
		<script src="./js/slide.js"></script>
		<script src="./js/login.js"></script>
</body>
</html>