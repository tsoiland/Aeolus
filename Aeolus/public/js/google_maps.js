var map;
var marker;

function initialize(arg) {
	if (arg!='') {
		// Setup map
		var latlng = new google.maps.LatLng(-20.0333, 148.969);
		var myOptions = {
		  zoom: 5,
		  center: latlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	}
	
	if(arg=='index') {
		// Call function that was printed from the controller to put incidents on map.
		addMarkers();
	} else if (arg=='add') {
		// Set up movable marker.
		var marker = addMarker('test', null, null, true, '');
		google.maps.event.addListener(map, 'click', function(event) {
			document.getElementById("longitude").value = event.latLng.lng().toFixed(6);
			document.getElementById("latitude").value = event.latLng.lat().toFixed(6);
			marker.setPosition(event.latLng);
		});
		google.maps.event.addListener(marker, 'dragend', function(event) {
			document.getElementById("longitude").value = event.latLng.lng().toFixed(6);
			document.getElementById("latitude").value = event.latLng.lat().toFixed(6);
		});
	} else if (arg=='edit') {
		// Set up movable marker.
		marker = addMarkerForEdit();
		google.maps.event.addListener(map, 'click', function(event) {
			document.getElementById("longitude").value = event.latLng.lng().toFixed(6);
			document.getElementById("latitude").value = event.latLng.lat().toFixed(6);
			marker.setPosition(event.latLng);
		});
		google.maps.event.addListener(marker, 'dragend', function(event) {
			document.getElementById("longitude").value = event.latLng.lng().toFixed(6);
			document.getElementById("latitude").value = event.latLng.lat().toFixed(6);
		});
	} else if (arg=='view') {
		// Set up static marker.
		addMarkerForView();
	}
}

function addMarker(title, latitude, longitude, draggable, html) {
	var latlng = new google.maps.LatLng(latitude, longitude);
	var marker = new google.maps.Marker({
	      position: latlng, 
	      map: map, 
	      title: title,
	      draggable: draggable,
	      aiseOnDrag: false
	});
	if(html != '') {
		var infowindow = new google.maps.InfoWindow({
		    content: html
		});
	
		google.maps.event.addListener(marker, 'click', function() {
		  infowindow.open(map,marker);
		});
	}
	return marker;
}  
