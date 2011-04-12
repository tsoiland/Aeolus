var map;


function initialize(arg) {
	if (arg!='') {
		// Setup map
		var latlng = new google.maps.LatLng(-34.397, 150.644);
		var myOptions = {
		  zoom: 8,
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
		addMarker('test', null, null, true);
		google.maps.event.addListener(map, 'click', function(event) {
			document.getElementById("longitude").value = event.latLng.lng().toFixed(6);
			document.getElementById("latitude").value = event.latLng.lat().toFixed(6);
			marker.setPosition(event.latLng);
		});
	}
}

function addMarker(title, latitude, longitude, draggable) {
	var latlng = new google.maps.LatLng(latitude, longitude);
	return marker = new google.maps.Marker({
	      position: latlng, 
	      map: map, 
	      title: title,
	      draggable: draggable,
	      aiseOnDrag: false
	  });
}  
