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
						//clientPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
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

			$("#search_button").click(function(event) {
				$("#search").popup("open", {
					x: 0,
					y: 0,
					transition: 'slideup',
					positionTo: 'origin'
				});
			});

			$("#fav_button").click(function(event) {
				$("#favorites").popup("open", {
					x: 0,
					y: 0,
					transition: 'slideup',
					positionTo: 'origin'
				});
			});

		});			
        </script>
    </head>
    <body>
	 	<div id="directionsmap" data-role="page">
		 	<div data-role="content" id="map_content" data-theme="a">
	                <div id="map"></div>
	        </div>
			<div id="nav-footer" data-role="footer" data-position="fixed" data-fullscreen="true" data-theme="a">
				<div style="float: left; margin-left: 15px;">
					<a id="search_button" href="#" data-inline="true" data-role="button" data-iconshadow="false" data-icon="search" data-iconpos="notext" style="margin-right: 20px;">Search</a>
					<a id="fav_button" href="#" data-inline="true" data-role="button" data-iconshadow="false" data-icon="star" data-iconpos="notext">Favorites</a>
				</div>
				<div style="text-align: right; vertical-align: middle; float:right; margin-right: 10px;">
						<label for="events">E</label> <select name="events" id="events" data-role="slider" data-inline="true" data-icon="search" data-mini="true">
							<option value="Off">Off</option>
							<option value="On">On</option>
						</select>&nbsp;
						<label for="buses">B</label> <select name="buses" id="buses" data-role="slider" data-inline="true" data-icon="search" data-mini="true">
							<option value="Off">Off</option>
							<option value="On">On</option>
						</select>
				</div>
				<!-- Search Popup -->
				<div data-role="popup" id="search" data-overlay-theme="a" data-theme="c" data-corners="false" class="ui-corner-all">
					<div data-role="header" data-theme="a" class="ui-corner-top">
						<h1>Search</h1>
					</div>
					<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
						<ul data-role="listview" data-filter="true" data-filter-reveal="true" data-filter-placeholder="Search places and events">
							<li><a href="index.html">Acura</a></li>
							<li><a href="index.html">Audi</a></li>
							<li><a href="index.html">BMW</a></li>
							<li><a href="index.html">Cadillac</a></li>
							<li><a href="index.html">Chrysler</a></li>
							<li><a href="index.html">Dodge</a></li>
							<li><a href="index.html">Ferrari</a></li>
							<li><a href="index.html">Ford</a></li>
							<li><a href="index.html">GMC</a></li>
							<li><a href="index.html">Honda</a></li>
							<li><a href="index.html">Hyundai</a></li>
							<li><a href="index.html">Infiniti</a></li>
							<li><a href="index.html">Jeep</a></li>
							<li><a href="index.html">Kia</a></li>
							<li><a href="index.html">Lexus</a></li>
							<li><a href="index.html">Mini</a></li>
							<li><a href="index.html">Nissan</a></li>
							<li><a href="index.html">Porsche</a></li>
							<li><a href="index.html">Subaru</a></li>
							<li><a href="index.html">Toyota</a></li>
							<li><a href="index.html">Volkswagon</a></li>
							<li><a href="index.html">Volvo</a></li>
						</ul>
					</div>
				</div>
				<!-- Favorites Popup -->
				<div data-role="popup" id="favorites" data-overlay-theme="a" data-theme="c" data-corners="false" class="ui-corner-all">
					<div data-role="header" data-theme="a" class="ui-corner-top">
						<h1>Favorites</h1>
					</div>
					<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
						<ul data-role="listview" data-filter="true" data-filter-reveal="false" data-filter-placeholder="Search favorites">
							<li><a href="index.html">Acura</a></li>
							<li><a href="index.html">Audi</a></li>
							<li><a href="index.html">BMW</a></li>
							<li><a href="index.html">BMW</a></li>
						</ul>  
					</div>
				</div>
			</div>			
		</div>
	</body>
</html>