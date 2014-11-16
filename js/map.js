window.onload = function(){
	loadMap();
}

var map;
var userLat = parseFloat(document.getElementById("lat").innerHTML);
var userLng = parseFloat(document.getElementById("lng").innerHTML);

function loadMap(){
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBeCrIde-bPXDHLhSLiNU2kF-twpsa1e6Y&libraries=places&' +
      'callback=initializeMap';

	document.body.appendChild(script);
}

function initializeMap() {
	var mapOptions = {
		center: {lat: userLat, lng: userLng},
		zoom: 7
	};

	map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
	
	placeMarker(new google.maps.LatLng(userLat, userLng));
	
	google.maps.event.addListener(map, 'click', function(event){
		placeMarker(event.latLng);
	});
}

var marker;

function placeMarker(location){
	if(circle){
		circle.setCenter(location);
		return;
	}
	if(marker){
		marker.setPosition(location);
	}
	else {
		document.getElementById('radiusSlider').value = '0';
		marker = new google.maps.Marker({
			position: location,
			map: map		
		});
	}
}

var circle;

function setCircleRadius(inputRadius){
	if(!marker){
		return;
	}
	document.getElementById('range').innerHTML = inputRadius + "km";
	if(circle){
		circle.setRadius(parseFloat(inputRadius)*1000);
		return;
	}
	var circleOptions = {
		fillColor: '#3a2agg',
		strokeColor: '#5a3aFF',
		strokeWeight: 2,
		map: map,
		radius: parseFloat(inputRadius)*1000
	}
	circle = new google.maps.Circle(circleOptions);
	circle.bindTo('center', marker, 'position');
}


