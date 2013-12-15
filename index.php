<!doctype html>
<html lang="en">
   <head>
		<title>UMD Cartographer</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
	 	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
		
		<link rel="stylesheet" href="styles/core.css" />
		
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>	
		<script src="scripts/jquery.ui.map.js"></script>
		<script src="scripts/jquery.ui.map.services.js"></script>		
		<script src="scripts/jquery.ui.map.extensions.js"></script>
		<script src="scripts/jquery.ui.map.overlays.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$('#map').gmap({'center': '38.9869367,-76.94286790000001', 'zoom': 18, 'disableDefaultUI':true, 'callback': function() {
				var self = this;
				var clientPosition = new google.maps.LatLng('38.9869367', '-76.94286790000001')
				var eventsLayer = new google.maps.KmlLayer('http://gmaps-samples.googlecode.com/svn/trunk/ggeoxml/cta.kml');
				var busesLayer = new google.maps.KmlLayer('http://gmaps-samples.googlecode.com/svn/trunk/ggeoxml/cta.kml');
				
				self.getCurrentPosition(function(position, status) {
					if ( status === 'OK' ) {
						clientPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					} 
					self.addMarker({'position': clientPosition, 'bounds': false, 'icon' : 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'});
					/*self.addShape('Circle', { 
						'strokeWeight': 0, 
						'fillColor': "#008595", 
						'fillOpacity': 0.25, 
						'center': clientPosition, 
						'radius': 15, 
						'clickable': false 
					});*/
					self.get('map').panTo(clientPosition);
				}); 

				// Events toggle
				$("#events").change(function() {
					var currValue = $("select#events option:selected").text();
					if (currValue == "On") {
						eventsLayer.setMap(self.get('map'));
					}
					else {
						eventsLayer.setMap(null);
					}
				});  

				// Bus overlay toggle
				$("#buses").change(function() {
					var currValue = $("select#buses option:selected").text();
					if (currValue == "On") {
						busesLayer.setMap(self.get('map'));
					}
					else {
						busesLayer.setMap(null);
					}
				});  

				
			}});

		});			
        </script>
    </head>
    <body>
	 	<div id="directionsmap" data-role="page">
		 	<div data-role="content" id="map_content" data-theme="a">
	                <div id="map"></div>
	        </div>
			<div id="nav-footer" data-role="footer" class="ui-grid-a" data-position="fixed" data-fullscreen="true" data-theme="a">
				<div class="ui-block-a" style="padding-left: 20px;">
					<a href="#search" data-rel="popup" data-position-to="window" data-inline="true" data-role="button" data-icon="search" data-transition="pop">Search</a>
					<a href="#favorites" data-rel="popup" data-position-to="window"  data-inline="true" data-role="button" data-icon="star" data-transition="pop">Favorites</a>
				</div>
				<div class="ui-block-b" style="padding-right: 20px; text-align: right; vertical-align: middle;">
						<label for="events">Events:</label> <select name="events" id="events" data-role="slider" data-inline="true" data-icon="search" data-mini="true">
							<option value="Off">Off</option>
							<option value="On">On</option>
						</select>&nbsp;
						<label for="buses">Buses:</label> <select name="buses" id="buses" data-role="slider" data-inline="true" data-icon="search" data-mini="true">
							<option value="Off">Off</option>
							<option value="On">On</option>
						</select>
				</div>
				<!-- Search Popup -->
				<div data-role="popup" id="search" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
					<div data-role="header" data-theme="a" class="ui-corner-top">
						<h1>Search</h1>
					</div>
					<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
						<h3 class="ui-title">Are you sure you want to delete this page?</h3>
						<p>This action cannot be undone.</p>
						<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>    
						<a href="#" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Delete</a>  
					</div>
				</div>
				<!-- Favorites Popup -->
				<div data-role="popup" id="favorites" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
					<div data-role="header" data-theme="a" class="ui-corner-top">
						<h1>Favorites</h1>
					</div>
					<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
						<h3 class="ui-title">Are you sure you want to delete this page?</h3>
						<p>This action cannot be undone.</p>
						<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>    
						<a href="#" data-role="button" data-inline="true" data-rel="back" data-transition="flow" data-theme="b">Delete</a>  
					</div>
				</div>
			</div>			
		</div>
	</body>
</html>