window.onload = function(){
	loadMap();
}

var map;
var userLat = 63.41;
var userLng = 10.44;

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
	};

	map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
	
	addSearchBox();
	google.maps.event.addListenerOnce(map, 'bounds_changed', function(){
		this.setZoom(7);
	});
	
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
		  marker = new google.maps.Marker({
			map: map,
			title: place.name,
			position: place.geometry.location
		  });

		  markers.push(marker);

		  bounds.extend(place.geometry.location);
		}
		map.fitBounds(bounds);
		map.setZoom(9);
	});
	// [END region_getplaces]

	// Bias the SearchBox results towards places that are within the bounds of the
	// current map's viewport.
	google.maps.event.addListener(map, 'bounds_changed', function() {
		var bounds = map.getBounds();
		searchBox.setBounds(bounds);
	});
}
