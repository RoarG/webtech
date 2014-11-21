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
		#userCategories{
			height: 110px;
			overflow: auto;
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
								
				//$db = mysqli_connect("mysql.stud.ntnu.no","audunasa_webtek","it2805","audunasa_prosjekt");
				$db = new mysqli("localhost", "roargcom_audun", "it2805", "roargcom_webtek");

				if (!$db) {
					echo('Could not connect: ' . mysqli_error($db));
				}
				
				$id = "0";
				$cookie_name = "userId";
				
				if(isset($_GET['id'])) {
					$id = $_GET['id'];				
				} else {
					if(isset($_COOKIE[$cookie_name])){
						$id = $_COOKIE[$cookie_name];
					}
					else{
						header("Location: ./index.html");
						die();
					}
				}

				$query = "SELECT * FROM medlemmer
							WHERE id = '".$id."';";
				$result = mysqli_query($db, $query);
				
				$name = "";
				$image = "";
				$rating = "";
				$bio = "";
				$categories = "";
				
				while($row = $result->fetch_assoc()) {
					$name = $row['navn'];
					$email = $row["mail"];
					$bio = $row['bio'];
					if($row['bildeURL']){
						$image = $row['bildeURL'];
					}
					else{
						$image = "./images/defaultUser.png";
					}
				}
				
				
				$query2 = "SELECT selgerId, ifnull(ROUND(avg(rating),2),0) as rating
						FROM jobber
						WHERE selgerId='".$id."'
						GROUP BY selgerId;";
				
				$result2 = mysqli_query($db, $query2);
				
				if ($result2->num_rows > 0) {
					while($row = $result2->fetch_assoc()) {
						$rating = $row['rating'];
					}
				} else {
					$rating = 0;
				}
				
				$query3 = "SELECT navn FROM kategori WHERE personId='".$id."';";

				$result3 = mysqli_query($db, $query3);
				
				if ($result3->num_rows > 0) {
					while($row = $result3->fetch_assoc()) {
						if(strcmp(strtolower($row['navn']), "snomaking") == 0 ){
							$categories[] = "Snømåking";
						}
						else if (strcmp(strtolower($row['navn']), "ga tur med hunden") == 0 ){
							$categories[] = "Gå tur med hunden";
						}
						else if (strcmp(strtolower($row['navn']), "mobelsammensetting") == 0 ){
							$categories[] = "Møbelsammensetting";
						}
						else {
							$categories[] = ucfirst($row['navn']);
						}
					}
				} else {
					$categories[] = "";
				}
				mysqli_close($db);
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
							<div id="textRating">
							<? echo($rating);?>/5
							</div>
						</div>
						
					</div>
					<script>
						var labels = document.getElementById('ratingDiv').getElementsByTagName('label');

						//Finner hvor mye det er igjen av rating etter å ha fylt ut de hele stjernene
						var rest = <? echo($rating);?> - Math.floor(<? echo($rating);?>);
						
						//Finner stjernen som er første ikke-hele stjerne. (labels er 0-indeksert).
						var labelNum = Math.floor(<? echo($rating);?>);
						
						//Finner hvor langt til høyre denne stjernen er. 24 er bredden av en stjerne.
						var nextStar = labelNum*24;
						
						//Finner ut hvor langt vi skal fylle opp den siste stjernen
						var sliceOfLastStar = nextStar+Math.ceil((rest*24));
						
						
						//Fyller ut stjernene.
						if(labelNum > 4){
							labels[4].style.background = "url('stars.png') -"+nextStar+"px -24px";
							labels[4].position = "absolute";
						}
						else{
							labels[labelNum].style.background = "url('stars.png') -"+nextStar+"px -24px";
							labels[labelNum].position = "absolute";
							//Clip tar et utklipp i form av et rektangel(top, right, bottom, left) av den siste stjernen
							//tilsvarende hvor mye den skal utfylles. SliceOfLastStar forteller hvor langt til høyre utklippet skal gå, dvs hvor mye stjernen skal fylles opp.
							labels[labelNum].style.clip = "rect(0, "+sliceOfLastStar+"px, 24px, 0)";
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
</body>
</html>