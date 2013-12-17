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

		//var eventsLayer = new google.maps.KmlLayer('http://dannybouman.com/cartographer/data/events.kml?'+(new Date()).getTime());
		//var busesLayer = new google.maps.KmlLayer('http://gmaps-samples.googlecode.com/svn/trunk/ggeoxml/cta.kml');
		var map,currentPosition,directionsDisplay,directionsService;
		var infowindow = new google.maps.InfoWindow();
		var eventIcon = new google.maps.MarkerImage(
			    "http://maps.google.com/mapfiles/kml/paddle/grn-diamond.png",
			    null, /* size is determined at runtime */
			    null, /* origin is 0,0 */
			    null, /* anchor is bottom center of the scaled image */
			    new google.maps.Size(32, 32)
			);
		var bounds = new google.maps.LatLngBounds ();
		var activeEvents = [];
		var events = []
		events['Adele H. Stamp Student Union Building'] = new Array('-76.94491733141443','38.98783329697648','Upcoming events:<br />6:00pm - Free tacos @ Taco Bell<br />7:00pm - Movie (Iron Man 3)');
		events['Geology Building'] = new Array('-76.942308','38.990855','test <a href="" class="test">test</a>');
		
		$(document).ready(function() {
			$('#map').gmap({'center': '38.9869367,-76.94286790000001', 'zoom': 18, 'disableDefaultUI':true, 'callback': function() {
				var self = this;
				map = self.get('map');
				currentPosition = new google.maps.LatLng('38.9869367', '-76.94286790000001');
				directionsDisplay = new google.maps.DirectionsRenderer(); 
	            directionsService = new google.maps.DirectionsService();
	            directionsDisplay.setMap(map);
			
				self.getCurrentPosition(function(position, status) {
					if ( status === 'OK' ) {
						//currentPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					} 
					self.addMarker({'position': currentPosition, 'bounds': false, 'icon' : 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'});
					/*self.addShape('Circle', { 
						'strokeWeight': 0, 
						'fillColor': "#008595", 
						'fillOpacity': 0.25, 
						'center': currentPosition, 
						'radius': 15, 
						'clickable': false 
					});*/
					map.panTo(currentPosition);
					bounds.extend(currentPosition);
				}); 

				// Events toggle
				$("#events").change(function() {
					var currValue = $("select#events option:selected").text();
					if (currValue == "On") {
						//eventsLayer.setMap(self.get('map'));
						addAllMarkers ( events, activeEvents, eventIcon);
					}
					else {
						//eventsLayer.setMap(null);
						removeAllMarkers (activeEvents);
					}
					
				});  

				// Bus overlay toggle
				$("#buses").change(function() {
					var currValue = $("select#buses option:selected").text();
					if (currValue == "On") {
						busesLayer.setMap(map);
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

		function addAllMarkers ( markers, active, icon) {
			var newBounds = bounds;
			for (var key in markers) {
			    var data = markers[key];
			    var latLng = new google.maps.LatLng (data[1], data[0])
			    var navBtn = '<div align="center"><a id="navbtn" onclick="navigate('+data[1]+','+ data[0] +');" style="width: 150px;" class="ui-btn ui-btn-up-b ui-shadow ui-btn-corner-all ui-btn-icon-left" data-wrapperels="span" data-iconshadow="true" data-shadow="true" data-corners="true" href="#" data-role="button" data-theme="b" data-icon="arrow-r"><span class="ui-btn-inner"><span class="ui-btn-text">Navigate</span><span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span></span></a></div>';
			    var marker = new google.maps.Marker({
			        position: latLng,
			        map: map,
			        animation: google.maps.Animation.DROP,
			        icon: icon,
			        title: key,
			        clickable: true,
			        html: '<h3>' + key + '</h3>' + data[2] + '<br /><br />' + navBtn
			    });

			    active.push(marker);
			    
		    	google.maps.event.addListener(marker, 'click', function() {
			    	infowindow.close();
			    	//console.log($(this).html());
		    		infowindow.setContent(this.html);
		    		infowindow.open(map, this);
		    	});
		    	
		    	bounds.extend (latLng);
			}
			map.fitBounds (newBounds);
		}

		function navigate(lat, lng) {
			var targetDestination = new google.maps.LatLng (lat, lng);
			if (currentPosition && currentPosition != '' && targetDestination && targetDestination != '') {
                var request = {
                    origin:currentPosition, 
                    destination:targetDestination,
                    travelMode: google.maps.DirectionsTravelMode["WALKING"]
                };

                directionsService.route(request, function(response, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        //directionsDisplay.setPanel(document.getElementById("directions"));
                        directionsDisplay.setDirections(response); 

                        /*
                            var myRoute = response.routes[0].legs[0];
                            for (var i = 0; i < myRoute.steps.length; i++) {
                                alert(myRoute.steps[i].instructions);
                            }
                        */
                        //$("#results").show();
                    }
                    else {
                        //$("#results").hide();
                    }
                });
            }
            else {
                //$("#results").hide();
            }
			infowindow.close();
		}

		function removeAllMarkers (active) {
			for (var i = 0; i < active.length; i++) {
				active[i].setMap(null);
			}	
			active = [];		
		}
					
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