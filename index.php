<!doctype html>
<html lang="en">
   <head>
		<title>Location Aware directions with Google Maps</title>
		<meta charset="utf-8" />
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>	
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
		<link rel="stylesheet" href="styles/core.css" />
		<style>
			#map_canvas_1 {
				width:	100%;
				min-height: 70%;
				background: black;	
			}
		</style>
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
		<script src="scripts/jquery.ui.map.js"></script>
		<script src="scripts/jquery.ui.map.services.js"></script>		
		<script src="scripts/jquery.ui.map.extensions.js"></script>
		<script type="text/javascript">
				
			var endlocation = { 'center': '53.7973333,-0.5', 'zoom': 10 };
			var start;
			var themap;
			var destination = "Richmond House,33 Richmond Hill,Bournemouth,Dorset,BH2 6EZ";

			
			$(document).ready(function() {
				$('#map').gmap({'center': endlocation.center, 'zoom': endlocation.zoom, 'disableDefaultUI':true, 'callback': function() {
				themap = this;

				$('#submit').click(function() {
					themap.displayDirections(
						{ 'origin': start, 'destination': destination, 'travelMode': google.maps.DirectionsTravelMode.DRIVING, 'unitSystem':google.maps.UnitSystem.METRIC }, 
						{ 'panel': document.getElementById('directions')}, 
						function(response, status) {
							( status === 'OK' ) ? $('#results').show() : $('#results').hide();
						});
						return false;
					});
				}});
				navigator.geolocation.getCurrentPosition(handle_geolocation_query);
			});
			
			function handle_geolocation_query(position){  
				lat = parseInt(position.coords.latitude*10000,10)/10000;
				lon = parseInt(position.coords.longitude*10000,10)/10000;   
				start = new google.maps.LatLng(lat, lon);
				themap.get('map').panTo(start);
				start = "Bournemouth Airport Bournemouth Airport Ltd (BOH), Hurn, Christchurch BH23 6DF";
			}			
							
        </script>
    </head>
    <body>
	 	<div id="directionsmap" data-role="page">
		 	<div data-role="content" id="map_content" data-theme="a">
	                <div id="map"></div>
	        </div>
			<div data-role="footer" class="ui-bar" data-position="fixed" data-theme="a">
				<a href="index.html" data-role="button" data-icon="search" data-iconpos="notext">Search</a>
				<a href="index.html" data-role="button" data-icon="search" data-iconpos="notext">Search</a>
			</div>			
		</div>
		<div id="about" data-role="page">
			<div data-role="header">
				<h1>Information about us</h1>
			</div>
			<div data-role="content">Holding page content</div>
		</div>
		<div id="info" data-role="page">	
			<div data-role="header">
				<h1>Info</h1>
			</div>				
			<div data-role="content">					
				Holding page content
	
			</div>
		</div>
	</body>
</html>