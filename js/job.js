window.onload = function (){
	initializeCal();
	if(sessionStorage.category){
		showUnderCat(sessionStorage.category);
	}
	getLocationAndLoadMap();
}

function submitJob(){
	if(!checkForm()){
		return;
	}
	var buyerId = parseInt(getCookie("userId"));
	var date = document.getElementById('mydate').value;
	var time = document.getElementById('mytime').value;
	var worker = document.querySelector('input[name="workersGroup"]:checked').value;
	var message = "Jobbforespørsel sendt! <br> Dato: "+date+"<br> Tid:"+time+"<br>Kategori:"+chosenUnderCat;

	var params = "id="+buyerId+"&date="+date+"&time="+time+"&worker="+worker+"&cat="+chosenUnderCat;
			
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			openPopupWindow(message, 0);
		}
	}
	/*Sender jobben til php-skript*/
	xmlhttp.open("POST", "./submitJob.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}
			
function checkForm(){
	var dateElement = document.getElementById("mydate");
	var timeElement = document.getElementById("mytime");
	/*Henter elementet i arbeiderlisten som er valgt*/
	var workerElement = document.querySelector('input[name="workersGroup"]:checked');

	if(!dateElement.value || !timeElement.value){
		return false;
	}
	if(!document.getElementById('underCat').hasChildNodes()){
		openPopupWindow("Velg kategori!", 1);
		return false;
	}
	if(!document.getElementById('people').hasChildNodes() && document.getElementById('underCat').childNodes[0].id != 'diverseMessage'){
		openPopupWindow("Velg underkategori!", 1);
		return false;
	}
	if(!workerElement){
		return false;
	}	
	return true;
}

function openPopupWindow(message, value){
	var overlay = document.getElementById("popupOverlay");
	var popup = document.getElementById("popupWindow");
	var tekst = document.getElementById("confirmTekst");
	
	overlay.style.display = "block";
	popup.style.display = "block";
	tekst.innerHTML = message;
      
	var confirmButton = document.createElement('button');
	confirmButton.setAttribute('type', 'button');
	confirmButton.id = 'confirmButton';
	confirmButton.innerHTML = "OK";
	
	if (value > 0) {
		confirmButton.setAttribute('onclick', 'emptyForm(1)');
	}else {
		confirmButton.setAttribute('onclick', 'emptyForm(0)');
	}
	
	popup.appendChild(confirmButton);
}

 function emptyForm(value){
	var overlay = document.getElementById("popupOverlay");
	var popup = document.getElementById("popupWindow");
	overlay.style.display = "none";
	popup.style.display = "none";
	
	/*Fjerner input bare dersom jobb er sendt til database*/
	if(value < 1){
		emptyUnderCategories();
		removeMapMarkers();
		emptyWorkersList();
		document.getElementById("mydate").value = "";
		document.getElementById("mytime").value = "";
	}
 }

/*MAP FUNCTIONS*/

var map;
var workerMarkers = [];

/*Disse verdiene må hentes fra Facebook/database*/
var userLat;
var userLng;

function getLocationAndLoadMap(){
	var userId = parseInt(getCookie("userId"));
	
	//For testing
	if(!userId){
		userId = 1497403270535912 ;
	}

	xmlRequest = new XMLHttpRequest();
	
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			/*Lagrer XML-string fra database*/
			var x = xmlhttp.responseText;
			/*Parser string til DOM-objekt*/
			var xmlDoc;		
			var parser = new DOMParser();
			xmlDoc = parser.parseFromString(x,'text/xml');
			var info = xmlDoc.getElementsByTagName('info');
			if (info.length<1){
				userLat=63.4;
				userLng=10.44;
			}
			for (var i=0; i<info.length; i++){
				userLat = parseFloat(info[i].childNodes[1].childNodes[0].nodeValue);
				userLng = parseFloat(info[i].childNodes[3].childNodes[0].nodeValue);
			}
			loadMap();
		}
	}
	xmlhttp.open("GET", "./getLocation.php?id="+userId, true);
	xmlhttp.send();	
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


function initializeMap() {
	var mapOptions = {
		center: {lat: userLat, lng: userLng},
	};

	map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
	
	var marker = new google.maps.Marker({
		position:{lat:userLat,
					lng:userLng},
		icon: {
			url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
		},
		map: map,
		title: "Her er du!"
	});
	addSearchBox();
	google.maps.event.addListenerOnce(map, 'bounds_changed', function(){
		this.setZoom(11);
	});
}
/*Ikke sikker på hva denne skal brukes til*/
function addSearchBox(){ //https://developers.google.com/maps/documentation/javascript/examples/places-searchbox
	var markers = [];
	
	var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(userLat-0.1, userLng-0.1),
      new google.maps.LatLng(userLat+0.1, userLng+0.1));
	map.fitBounds(defaultBounds);
	
	var input = document.getElementById('search');
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	var searchBox = new google.maps.places.SearchBox(input);
	google.maps.event.addListener(searchBox, 'places_changed', function() {
		var places = searchBox.getPlaces();

		if (places.length == 0) {
		  return;
		}
		for (var i = 0, marker; marker = markers[i]; i++) {
		  marker.setMap(null);
		}

		// For each place, get the icon, place name, and location.
		markers = [];
		var bounds = new google.maps.LatLngBounds();
		for (var i = 0, place; place = places[i]; i++) {
		  var image = {
			url: place.icon,
			size: new google.maps.Size(71, 71),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(17, 34),
			scaledSize: new google.maps.Size(25, 25)
		  };

		  // Create a marker for each place.
		  var marker = new google.maps.Marker({
			map: map,
			icon: image,
			title: place.name,
			position: place.geometry.location
		  });

		  markers.push(marker);

		  bounds.extend(place.geometry.location);
		}
		map.fitBounds(bounds);
		map.setZoom(13);
	});
	// [END region_getplaces]

	// Bias the SearchBox results towards places that are within the bounds of the
	// current map's viewport.
	google.maps.event.addListener(map, 'bounds_changed', function() {
		var bounds = map.getBounds();
		searchBox.setBounds(bounds);
	});
}

function loadMap(){
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBeCrIde-bPXDHLhSLiNU2kF-twpsa1e6Y&libraries=places&' +
      'callback=initializeMap';

	document.body.appendChild(script);
}
var workers;

function setMapMarkers(workersXML){
	workers = workersXML.getElementsByTagName("person");
	if(workers.length<1){
		return;
	}
	for(var i=0; i<workers.length; i++){
		if(workers[i].childNodes[7].childNodes[0].nodeValue != 0){	
			var marker = new google.maps.Marker({
				position: {lat: parseFloat(workers[i].childNodes[3].childNodes[0].nodeValue), 
							lng: parseFloat(workers[i].childNodes[5].childNodes[0].nodeValue)},
				map: map,
				title: "Id:"+workers[i].childNodes[1].childNodes[0].nodeValue,
				icon: {
					url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
				}
			});
			workerMarkers.push(marker);
			google.maps.event.addListener(marker, 'click', function(){
				highlightWorkerAndMarker(this.getTitle());
			});
		}
	}
}	
function removeMapMarkers(){
	for(var i=0; i<workerMarkers.length; i++){
		workerMarkers[i].setMap(null);
	}
	workersArray = [];
	workerMarkers = [];
	labels = [];
	
	document.getElementById("changingUnderCat").innerHTML = "";
}	
var chosenUnderCat;
function updateMap(underCategory){
	chosenUnderCat = underCategory;
	removeMapMarkers();
	emptyWorkersList();
	
	var mapHeader = document.getElementById("changingUnderCat");
	mapHeader.innerHTML = "i underkategorien "+underCategory;
	
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			/*Lagrer XML-string fra database*/
			var x = xmlhttp.responseText;
			/*Parser string til DOM-objekt*/
			var parser = new DOMParser();
			var xmlDoc = parser.parseFromString(x,"text/xml");
			setMapMarkers(xmlDoc);
			setWorkersList();
		}
	}
	/*Henter personer som jobber med aktuell kategori i nærheten*/
	xmlhttp.open("GET", "./getUsersNearBy.php?cat="+underCategory+
											"&lat="+userLat+"&long="+userLng, true);
	xmlhttp.send();
}

function highlightWorkerAndMarker(id){
	for(var i=0; i<workersArray.length; i++){
		if(workersArray[i].id===id.split(":")[1]){
			workersArray[i].firstChild.firstChild.checked = true;
			workersArray[i].style.backgroundColor = "rgba(119,209,119,0.6)";
			workerMarkers[i].setIcon({
				url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
			});
		}
		else {
			workersArray[i].firstChild.firstChild.checked = false;
			workersArray[i].style.backgroundColor = "";
			workerMarkers[i].setIcon({
				url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
			});
		}
	}
}
var workersArray = [];
var labels = [];

function setWorkersList(){
	var parent = document.getElementById('people');
	if(workers.length < 1){
		var noWorker = document.createElement('p');
		noWorker.innerHTML = "Ingen arbeidstakere i aktuell underkategori";
		
		parent.appendChild(noWorker);
		return;
	}
	
	for(var i=0; i<workers.length; i++){
		var newSpan = document.createElement('span');
		newSpan.className = "workers";
		newSpan.id = workers[i].childNodes[1].childNodes[0].nodeValue;;
		
		var newRadio = document.createElement('input');
		newRadio.setAttribute('type', 'radio');
		newRadio.setAttribute('name', 'workersGroup');
		newRadio.setAttribute('value', workers[i].childNodes[1].childNodes[0].nodeValue);
		newRadio.setAttribute('required', '');
		
		newRadio.id = workers[i].childNodes[1].childNodes[0].nodeValue;
		
		var radioButtonSpan = document.createElement('span');
		radioButtonSpan.className = "workersRadio";
		radioButtonSpan.appendChild(newRadio);
		
		var pictureSpan = document.createElement('span');
		pictureSpan.className = "workerPicture";
		
		var image = document.createElement('img');
		image.className = "userImage";
		//Sjekker om personen har bilde. Mest for testing.
		if(workers[i].childNodes[13].childNodes[0]){
			image.setAttribute('src', workers[i].childNodes[13].childNodes[0].nodeValue);
		}
		else{
			image.setAttribute('src', './images/defaultUser.png');
		}
		pictureSpan.appendChild(image);
		
		var radioLabel = document.createElement('label');
		radioLabel.className = "labels";
		
		radioLabel.innerHTML += "Navn: "+workers[i].childNodes[9].childNodes[0].nodeValue+" <br>";
		radioLabel.innerHTML += "Rating: "+workers[i].childNodes[11].childNodes[0].nodeValue+" <br>";
		radioLabel.innerHTML += "Avstand fra deg: "+workers[i].childNodes[7].childNodes[0].nodeValue +"km <br>";
		
		newSpan.appendChild(radioButtonSpan);
		newSpan.appendChild(pictureSpan);
		newSpan.appendChild(radioLabel);
		
		if(workers[i].childNodes[7].childNodes[0].nodeValue != 0){
			parent.appendChild(newSpan);
			workersArray.push(newSpan);
			labels.push(radioLabel);
		}
	
		
	}
	for(var j=0; j<workersArray.length; j++){
		workersArray[j].onclick = function(){
			highlightWorkerAndMarker("id:"+this.id);
		}
	}
}

function emptyWorkersList(){
	var peopleNode = document.getElementById("people");
	while(peopleNode.firstChild){
		peopleNode.removeChild(peopleNode.firstChild);
	}
	workersArray = [];
}

/*CALENDAR FUNCTIONS*/

function initializeCal(){
	var date = new Date();
	var year = date.getFullYear();
	var month = date.getMonth();
	var day = date.getDate();
	$('#mydate').glDatePicker(
		{
			showAlways:false,
			dowOffset: 1,
			selectableDateRange:[
				{from: new Date(year, month, day),
				to: new Date(year+1, month, day)}
			]
	});
	
	$('#mytime').timepicker(
	{
		'timeFormat': 'H:i',
		'scrollDefault': '12:00'
	});	
}

/*CATEGORY FUNCTIONS*/

var categories = {
			"husarbeid":["Plenklipping", "Vasking", "Rydding", "Snømåking"],
			"personlig assistent":["Lekser", "Gå tur med hunden", "Handling"], 
			"handyman":["Flytting", "Møbelsammensetting", "PC-hjelp", "Bilderedigering"], 
			"annet":[]
};

var catButtonList = [];

function changeCatButtonStyle(underCategory){
	for(var i=0; i<catButtonList.length; i++){
		if(catButtonList[i].value == underCategory){
			catButtonList[i].style.backgroundColor = "rgb(255,99,71)";
		}
		else{
			catButtonList[i].style.backgroundColor = "";
		}
	}
}

function emptyUnderCategories(){
	document.getElementById("changingCat").innerHTML = "";
	var parentNode = document.getElementById("underCat");
	while(parentNode.firstChild){
		parentNode.removeChild(parentNode.firstChild);
	}
	catButtonList = [];
}

function showUnderCat(category){
	emptyUnderCategories();
	
	var underCatHeader = document.getElementById("changingCat");
	var parentNode = document.getElementById("underCat");
	if(category == "annet"){
		underCatHeader.innerHTML = "";
		
		var diverseMessage = document.createElement('p');
		diverseMessage.id = "diverseMessage";
		diverseMessage.innerHTML = "Se kart for alle arbeidstakere som har krysset av for at de kan utføre diverse oppgaver";
		
		parentNode.appendChild(diverseMessage);
		emptyWorkersList();
		updateMap(category);
		return;
	}
	underCatHeader.innerHTML = " i kategorien " + category;

	var underCatArray = categories[category];
	for(var i=0; i<underCatArray.length; i++){
		var underCat = underCatArray[i];

		var newUnderCat = document.createElement('input');
		newUnderCat.setAttribute('required', '');
		newUnderCat.type = "button";
		newUnderCat.value = underCat;
		newUnderCat.innerHTML = underCat;
		newUnderCat.className = "underCatButton";
		
		catButtonList.push(newUnderCat);
		
		newUnderCat.onclick = function(){
			changeCatButtonStyle(this.value);
			updateMap(this.value);
		}			
		parentNode.appendChild(newUnderCat);		
	}
	
}