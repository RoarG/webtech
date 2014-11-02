<!DOCTYPE html>
<html>
	<head>
		<title>Jobbforespøsel sendt</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="page">
			<div class="header">
				<div class="login">
					<div class="loginId">
					</div>
					<div class="loginId">
						<div id="name">
						</div>
					</div>
				</div>
				<div class="logo">
					<img src="webtech/images/logo.png">
				</div>
				<div class="box">
					<a>Min Side</a>
				</div>
				<div class="box">
					<a>Hjelp</a>
				</div>
				<div class="box">
					<a>Om Siden</a>
				</div>
			</div>
			<div>
				<?php
					$date = $_POST['date'];
					$time = $_POST['time'];
					$category = $_POST['category'];
					$selectedWorker = $_POST['workersGroup'];
					
					echo "Følgende verdier ble sendt:<br> Dato: ";
					echo($date);
					echo "<br> Tid: ";
					echo($time);
					echo "<br> Kategori: ";
					echo($category);
					echo "<br> Valgt arbeidstaker: ";
					echo($selectedWorker);

				?>
			</div>
		</div>
	</body>
</html>