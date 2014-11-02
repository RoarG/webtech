window.onload = function (){
	initializeCal();
	initializeCat();
	loadMap();
}

/*MAP FUNCTIONS*/

var map;
var markers = [];
var userLat = 63.418
var userLng = 10.444

function initializeMap() {
	var mapOptions = {
		center: {lat: userLat, lng: userLng},
		zoom: 10
	};

	map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
	addSearchBox();
}
function addSearchBox(){ //https://developers.google.com/maps/documentation/javascript/examples/places-searchbox
	var markers = [];
	
	var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(63.318, 10.344),
      new google.maps.LatLng(63.518, 10.544));
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
		var marker = new google.maps.Marker({
			position: {lat: parseFloat(workers[i].childNodes[3].childNodes[0].nodeValue), 
						lng: parseFloat(workers[i].childNodes[5].childNodes[0].nodeValue)},
			map: map,
			title: "id:"+workers[i].childNodes[1].childNodes[0].nodeValue,
		});
		markers.push(marker);
		google.maps.event.addListener(marker, 'click', function(){
			highlightWorkerAndMarker(this.getTitle());
		});
	}
	map.setZoom(12);
}	
function removeMapMarkers(){
	for(var i=0; i<markers.length; i++){
		markers[i].setMap(null);
	}
	workersArray = [];
	markers = [];
}	

function updateMap(underCategory){
	if(underCategory<0 || underCategory>6){
		return;
	}
	removeMapMarkers();
	emptyWorkersList();
	
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			/*Lagrer XMl-string fra database*/
			var x = xmlhttp.responseText;
			/*Parser string til DOM-objekt*/
			var parser = new DOMParser();
			var xmlDoc = parser.parseFromString(x,"text/xml");
			setMapMarkers(xmlDoc);
			setWorkersList();
		}
	}
	/*Henter personer som jobber med aktuell kategori*/
	xmlhttp.open("GET", "/getUsersNearBy.php?q="+underCat[underCategory], true);
	xmlhttp.send();
}

function highlightWorkerAndMarker(id){
	for(var i=0; i<workersArray.length; i++){
		if(workersArray[i].id===id.split(":")[1]){
			workersArray[i].checked = true;
			labels[i].style.backgroundColor = "#D5E0D9";
			markers[i].setIcon({
				url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
				size: new google.maps.Size(36,44)
			});
		}
		else {
			workersArray[i].checked = false;
			labels[i].style.backgroundColor = "white";
			markers[i].setIcon({
				url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
				size: new google.maps.Size(36,44)
			});
		}
	}
}
var workersArray = [];
var labels = [];

function setWorkersList(){
	var parent = document.getElementById('people');
	for(var i=0; i<workers.length; i++){
		var newRadio = document.createElement('input');
		newRadio.setAttribute('type', 'radio');
		newRadio.setAttribute('name', 'workersGroup');
		newRadio.setAttribute('value', "Id: "+workers[i].childNodes[1].childNodes[0].nodeValue);
		
		newRadio.id = workers[i].childNodes[1].childNodes[0].nodeValue;
		
		var radioSpan = document.createElement('span');
		radioSpan.className = "workersRadio";
		radioSpan.appendChild(newRadio);
		
		var radioLabel = document.createElement('label');
		radioLabel.className = "workers";
		
		radioLabel.innerHTML += "Id: "+workers[i].childNodes[1].childNodes[0].nodeValue +"<br>";
		radioLabel.innerHTML += "Bio: "+workers[i].childNodes[7].childNodes[0].nodeValue + "<br>";
		
		parent.appendChild(radioSpan);
		parent.appendChild(radioLabel);
		
		workersArray.push(newRadio);
		labels.push(radioLabel);
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
}

/*CALENDAR FUNCTIONS*/

function initializeCal(){
	$('#mydate').glDatePicker(
		{
			showAlways:true,
			dowOffset: 1,
			selectableDateRange:[
				{from: new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate()),
				to: new Date(9999,1,1)}
			]
	});
	
	$('#mytime').timepicker(
	{
		'timeFormat': 'H:i'
	});	
}



/*CATEGORY FUNCTIONS*/

var categories = ["hus", "flytt", "pers", "handy", "diverse"];
var underCat = ["plenklipping", "handling", "lekser", "hund", "bilde", "møbel", "pc"];
var underCategories = document.getElementsByClassName("underCat");

function initializeCat(){
	for(var i in underCategories){
		if(underCategories[i].tagName == "SPAN"){
			underCategories[i].style.display = 'none';
		}
	}
}

function showUnderCat(category){
	var newActiveElement = document.getElementById([categories[category]]);
	for(var i in categories){
		if(categories[i] != "flytt" && (categories.indexOf(categories[i]) > -1)){
			var element = document.getElementById(categories[i]);
			var button = document.getElementById([categories[i]]+"Button");
			if (element == newActiveElement){
				if(element.style.display == 'block'){
					element.style.display = 'none';
					button.style.backgroundColor = "rgba(0,99,0,0.4)";
				}
				else{
					element.style.display = 'block';
					button.style.backgroundColor = "rgba(0,99,0,0.6)";
				}
			}
			else {
				element.style.display = 'none';
				button.style.backgroundColor = "rgba(0,99,0,0.4)";
			}
		}
	}
}