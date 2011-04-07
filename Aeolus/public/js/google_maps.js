var map;


function initialize() {
	var latlng = new google.maps.LatLng(-34.397, 150.644);
	var myOptions = {
	  zoom: 8,
	  center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	//addMarkers();
	
	var marker = new google.maps.Marker({
		position: latlng,
		map: map, 
	    title: 'test'
	  });
	
	google.maps.event.addListener(map, 'click', function(event) {
		marker.setPosition(event.latLng);
	});
	return false;
}

function addMarker(title, latitude, longitude) {
	var latlng = new google.maps.LatLng(latitude, longitude);
	var marker = new google.maps.Marker({
	      position: latlng, 
	      map: map, 
	      title: title
	  });
}  
