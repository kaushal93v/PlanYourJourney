<?php
     
function get_confirmed_locations(){
    $con=mysqli_connect ("localhost", 'root', 'admin','bitnami_wordpress');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    

    // update location with location_status if admin location_status.
  /*  $sqldata = mysqli_query($con,"SELECT LONGITUDE, LATITUDE FROM dataset WHERE SUBURB = 'MELBOURNE'");  */
     $sqldata = mysqli_query($con,"SELECT LONGITUDE, LATITUDE FROM bikecrashes"); 
    
 

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}



function get_toilet_locations(){
    $con=mysqli_connect ("localhost", 'root', 'admin','bitnami_wordpress');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    

    // update location with location_status if admin location_status.
  /*  $sqldata = mysqli_query($con,"SELECT LONGITUDE, LATITUDE FROM dataset WHERE SUBURB = 'MELBOURNE'");  */
     $sqldata = mysqli_query($con,"SELECT lon, lat FROM public_toilet"); 
    
 

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}



    
function get_drinking_locations(){
    $con=mysqli_connect ("localhost", 'root', 'admin','bitnami_wordpress');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    

    // update location with location_status if admin location_status.
  /*  $sqldata = mysqli_query($con,"SELECT LONGITUDE, LATITUDE FROM dataset WHERE SUBURB = 'MELBOURNE'");  */
     $sqldata = mysqli_query($con,"SELECT lon, lat FROM drinking_fountains"); 
    
 

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}


?>


<?php get_header(); ?>

 <style>
      #map {
        height: 500px;
        margin-top: 5px;
        }
    html, body {
        height: 100%;
        width: 100%;
        margin: 0px;
        padding: 0px;
    }
       
      button.butn{
          margin-top: 10px;
          background-color: aliceblue; /* Green */
          border: 1px solid black;
          border-radius: 12px;
          color: black;
         /*padding: 1px 5px;*/
         padding: 5px 10px; 
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          -webkit-transition-duration: 0.4s; /* Safari */
          transition-duration: 0.4s;
      }
      button.butn:hover {
          background-color: skyblue; /* Green */
          color: black;
        }
 
      #origin-input{
        border-color: black;
        background-color: #fff;
        margin-left: 0px;
        margin-top: 0px;
        border-radius: 12px;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 200px;
        height: 30px;
     }
      #destination-input {
        border-color: black;
        background-color: #fff;
        margin-left: -200px;
        margin-top: 32px;
        border-radius: 12px;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 200px;
        height: 30px;
      }

      #origin-input:focus,
      #destination-input:focus {
        border-color: black;
      }
    /* The popup bubble styling. */
    .popup-bubble {
      /* Position the bubble centred-above its parent. */
      position: absolute;
      top: 0;
      left: 0;
      transform: translate(-50%, -100%);
      /* Style the bubble. */
      background-color: white;
      padding: 5px;
      border-radius: 5px;
      font-family: sans-serif;
      overflow-y: auto;
      max-height: 60px;
      box-shadow: 0px 2px 10px 1px rgba(0,0,0,0.5);
    }
    /* The parent of the bubble. A zero-height div at the top of the tip. */
    .popup-bubble-anchor {
      /* Position the div a fixed distance above the tip. */
      position: absolute;
      width: 100%;
      bottom: /* TIP_HEIGHT= */ 8px;
      left: 0;
    }
    /* This element draws the tip. */
    .popup-bubble-anchor::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      /* Center the tip horizontally. */
      transform: translate(-50%, 0);
      /* The tip is a https://css-tricks.com/snippets/css/css-triangle/ */
      width: 0;
      height: 0;
      /* The tip is 8px high, and 12px wide. */
      border-left: 6px solid transparent;
      border-right: 6px solid transparent;
      border-top: /* TIP_HEIGHT= */ 8px solid white;
    }
    /* JavaScript will position this div at the bottom of the popup tip. */
    .popup-container {
      cursor: auto;
      height: 0;
      position: absolute;
      /* The max width of the info window. */
      width: 200px;
    }
</style>
<head>
    <meta charset="utf-8">
      <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <title>JourneyPlanner</title> 
    <div class="hero-image">
      <div class="hero-text">
        <h1>Choose the safest and quickest route to your destination</h1>
        <p> Find out the traffic conditions in your route and know whether your route has bike lanes. Explore the heatmap of past five years bike accidents in Melbourne CBD.Plan your daily routes by exploring the below map.</p>
         <button onclick="scrolldown()">CHOOSE NOW</button>
      </div>
    </div>
<style>
/*
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}
*/
.hero-image {
  background-image:url("https://i.imgur.com/SmPBGww.jpg");
  height: 550px;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}
.hero-text h1{
  text-align: center;
  position: absolute;
  top: 60%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  font-size: 28px;
  font-weight: bold;
}

.hero-text p{
  text-align: center;
  position: absolute;
  top: 75%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  font-size: 16px;   
}
    

.hero-text button {
  position: absolute;
  top: 90%;
  left: 50%;
  transform: translate(-50%, -50%);
  border: 2px solid;
  border-radius: 24px;
  outline: 0;
/*  display: inline-block;*/
  padding: 5px 20px;
  color: white;
  background-color: transparent;
  text-align: center;
  cursor: pointer;
  font-weight: bold;
  font-size: 14px;   


}

.hero-text button:hover {
  background-color: white;
  border-color: white;
  color: black;
  font-weight: bold;
  font-size: 14px;   

}
            
</style>
</head>
 <head>
<style>
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropdown {
  position: relative;
  display: inline-block;
  
}

.dropdown-content {
  display: none;
  position: absolute;
   background-color: aliceblue;
 background-repeat: repeat-x;
  min-width: 260px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  padding: 12px 16px;
  z-index: 10;
  
  font-size: 16px;
   text-align: center;
          text-decoration: none;
     
}
    

.dropdown-content a {
  color: black;
  padding: 2px 60px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #FFFFFF}

.dropdown:hover .dropdown-content {
  display: block;
    bottom: 100%; /* added this attribute */

    }
    
    
.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
</style>
     
     
     

</head>

<body>
<!--
    <div style="position: relative;top:100px">
    <p><b>Important Note for the users:</b> If you want to edit/add a new origin and destination, please click on reset button. All the routes which appear on the map are colored based on the route's safety level</p>
    <ul>
    <li>Green colored route indicates high safety level</li>
    <li>Grey colored route indicates mediatory safety level</li>
    <li>Red colored route indicates low safety level</li>
    </ul>
    </div>
-->
    
    
    <div style="position: relative;top:100px">
        <h1> </h1>
        <h1> </h1>
    <p>    </p>
    
    </div>
    
    
    <div style="display: none">
        <input id="origin-input" class="controls" type="text"
            placeholder="Enter an origin">

        <input id="destination-input" class="controls" type="text"
            placeholder="Enter a destination">
    </div>

      
    
      
    
    <div id="floating-panel" >
        
        
        
        
                <div class="dropdown">
<button class = "butn" onclick="toggleHeatmap()">Heatmap</button>
  <div class="dropdown-content">
 
    <p>The heatmap depicts accident-prone areas in Melbourne. </p>
  </div>
</div>
        
        
     
                        <div class="dropdown">
  <button class = "butn" onclick="addbikelanes()">Bike Lanes</button>
  <div class="dropdown-content">
 
 
       <p>Display all bike lanes in Melbourne. </p>
  </div>
</div>
        
             
                        <div class="dropdown">
  <button class = "butn" onclick="addtraffic()">Traffic Condition</button>
  <div class="dropdown-content">
 
   
     <p>  Explore the on-going traffic conditions in Melbourne. </p>
  </div>
</div>
        
        
        
        
        
        
        
                            <div class="dropdown">
  <button class = "butn" onclick="bikeshare()">Share Bike</button>
  <div class="dropdown-content">
   
    <p>Find the locations where you can rent a share bike. </p>
      
      
  </div>
</div>
     
                
          <div class="dropdown">
  <button class = "butn" onclick="toilet()">Public Toilet</button>
  <div class="dropdown-content">
   
    <p>View all public toilet locations on the map. </p>
      
      
  </div>
</div>
                          
        
        
                                    <div class="dropdown">
   <button class = "butn" onclick="drinking_fountains()">Drinking Fountain</button>
  <div class="dropdown-content">
 
    <p>View all drinking fountains on the map. </p>
  </div>
</div>
       
      

    
    
     <div class="dropdown">
   <button class = "butn" onclick="initMap()">Reset</button>
  <div class="dropdown-content">
 
    <p>Clear all icons and routes on the map. </p>
  </div>
</div>
    
    </div>
    
    <div id="map"></div>

      </body>


    <script>
      var map;
      function initMap() {
        createInputs()
          
          
                var NEW_ZEALAND_BOUNDS = {
        north: -37.4909,
        south: -38.4734,
        west: 144.4987,
        east: 145.8726,
      };
      var AUCKLAND = {lat: -37.06, lng: 174.58};
          
          
          
        map = new google.maps.Map(document.getElementById('map'), {
          mapTypeControl: false,
          zoom: 13,
              restriction: {
            latLngBounds: NEW_ZEALAND_BOUNDS,
            strictBounds: false,         
          },                   
          center: {lat: -37.8136, lng: 144.9631},
          disableDefaultUI: false
        });
           /*   restriction: {latLngBounds:{north:-37.4909 , south: -38.4734, west: 144.4987, east: 145.8726}},  */
        Popup = createPopupClass();

        bikeLayer = new google.maps.BicyclingLayer();
          
        trafficLayer = new google.maps.TrafficLayer();

         
        heatmap = new google.maps.visualization.HeatmapLayer({
          data: getPoints(),
        //  map: map
        });
         
        heatmap.set('radius',20);
          
        new AutocompleteDirectionsHandler(map);
          
          
      }


        function scrolldown(){
            window.scrollTo(0, 700)
        }
      // This example requires the Visualization library. Include the libraries=visualization
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization">

      var map, heatmap, bikeLayer,trafficLayer, directionsService, directionsDisplay, onChangeHandler;
      var polylineOptionsActual = (color) => ({
	      strokeColor: color,
	      strokeOpacity: 1.0,
	      strokeWeight: 5
      });
        function createInputs() {
            
            
            

                const div = document.createElement("div");
                div.style.display = "none";

                const originInput = document.createElement("input");
                originInput.id = "origin-input";
                originInput.className = "controls";
                originInput.type = "text";
                originInput.placeholder = "Enter an origin";

                const destinationInput = document.createElement("input");
                destinationInput.id = "destination-input";
                destinationInput.className = "controls";
                destinationInput.type = "text";
                destinationInput.placeholder = "Enter an destination";

                div.appendChild(originInput);
                div.appendChild(destinationInput);

                document.body.appendChild(div);
              }
        

       /**
         * Returns the Popup class.
         *
         * Unfortunately, the Popup class can only be defined after
         * google.maps.OverlayView is defined, when the Maps API is loaded.
         * This function should be called by initMap.
         */
        function createPopupClass() {
          /**
           * A customized popup on the map.
           * @param {!google.maps.LatLng} position
           * @param {!Element} content The bubble div.
           * @constructor
           * @extends {google.maps.OverlayView}
           */
          function Popup(position, content) {
            this.position = position;

            var contentEl = document.createElement('div');

            contentEl.innerText = content;

            contentEl.classList.add('popup-bubble');

            // This zero-height div is positioned at the bottom of the bubble.
            var bubbleAnchor = document.createElement('div');
            bubbleAnchor.classList.add('popup-bubble-anchor');
            bubbleAnchor.appendChild(contentEl);

            // This zero-height div is positioned at the bottom of the tip.
            this.containerDiv = document.createElement('div');
            this.containerDiv.classList.add('popup-container');
            this.containerDiv.appendChild(bubbleAnchor);

            // Optionally stop clicks, etc., from bubbling up to the map.
            google.maps.OverlayView.preventMapHitsAndGesturesFrom(this.containerDiv);
          }
          // ES5 magic to extend google.maps.OverlayView.
          Popup.prototype = Object.create(google.maps.OverlayView.prototype);

          /** Called when the popup is added to the map. */
          Popup.prototype.onAdd = function() {
            this.getPanes().floatPane.appendChild(this.containerDiv);
          };

          /** Called when the popup is removed from the map. */
          Popup.prototype.onRemove = function() {
            if (this.containerDiv.parentElement) {
              this.containerDiv.parentElement.removeChild(this.containerDiv);
            }
          };

          /** Called each frame when the popup needs to draw itself. */
          Popup.prototype.draw = function() {
            var divPosition = this.getProjection().fromLatLngToDivPixel(this.position);

            // Hide the popup when it is far out of view.
            var display =
                Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000 ?
                'block' :
                'none';

            if (display === 'block') {
              this.containerDiv.style.left = divPosition.x + 'px';
              this.containerDiv.style.top = divPosition.y + 'px';
            }
            if (this.containerDiv.style.display !== display) {
              this.containerDiv.style.display = display;
            }
          };

          return Popup;
        } 
    function AutocompleteDirectionsHandler(map) {
          this.map = map;
          this.originPlaceId = null;
          this.destinationPlaceId = null;
          this.travelMode = 'BICYCLING';
          this.directionsService = new google.maps.DirectionsService;
          this.directionsDisplay = new google.maps.DirectionsRenderer({suppressBicyclingLayer: true,suppressMarkers: false, polylineOptions: polylineOptionsActual("#000000")});
          this.directionsDisplay.setMap(map);
        
          var options = {
//              bounds: cityBounds,
//              types: ['(regions)'],
//              strictBounds: true
              componentRestrictions: {country: 'au'}
            };

          var originInput = document.getElementById('origin-input');
          var destinationInput = document.getElementById('destination-input');

          var originAutocomplete = new google.maps.places.Autocomplete(originInput, options);
          // Specify just the place data fields that you need.
          originAutocomplete.setFields(['place_id']);

          var destinationAutocomplete =
              new google.maps.places.Autocomplete(destinationInput,options);
          // Specify just the place data fields that you need.
          destinationAutocomplete.setFields(['place_id']);

          this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
          this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

          this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
          this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(
              destinationInput);
    }

    // Sets a listener on a radio button to change the filter type on Places
    // Autocomplete.
    AutocompleteDirectionsHandler.prototype.setupClickListener = function(
        id, mode) {
      var radioButton = document.getElementById(id);
      var me = this;

      radioButton.addEventListener('click', function() {
        me.travelMode = mode;
        me.route();
      });
    };

    AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(
        autocomplete, mode) {
      var me = this;
      autocomplete.bindTo('bounds', this.map);

      autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();

        if (!place.place_id) {
          window.alert('Please select an option from the dropdown list.');
          return;
        }
        if (mode === 'ORIG') {
          me.originPlaceId = place.place_id;
        } else {
          me.destinationPlaceId = place.place_id;
        }
        me.route();
      });
    };
        


    AutocompleteDirectionsHandler.prototype.route = function() {
        
        
        
      if (!this.originPlaceId || !this.destinationPlaceId) {
        return;
      }
      var me = this;

      this.directionsService.route(
          {
            origin: {'placeId': this.originPlaceId},
            destination: {'placeId': this.destinationPlaceId},
            travelMode: this.travelMode,
            provideRouteAlternatives: true
          },
          function(response, status) {
              const showRouteInfo = (route, content, index) => {
              const routeCenterIndex = Math.floor((route.overview_path || []).length / 2);
              const routeCenter = route.overview_path[routeCenterIndex + Math.ceil(1.5*index)] || route.overview_path[routeCenterIndex];

              if(routeCenter) {
                const lat = routeCenter.lat(),
                      lng = routeCenter.lng();

                var popup = new Popup(
                new google.maps.LatLng(lat, lng), content);
                popup.setMap(map);
              }          
            }
            if (status === 'OK') {
              var routes = response.routes;
              delete response.routes;
                var routes_points = []
            routes.reverse().forEach((route, index) => {
                
                const routeAccidentPoints = getNearestAccidentPointsOnRoute(route);

                 routes_points.push(routeAccidentPoints.length)

              });
                
              routes.reverse().forEach((route, index) => {
                var routeResponse = {...response};
                routeResponse.routes = [route];
                const routeAccidentPoints = getNearestAccidentPointsOnRoute(route);
                var dist = route.legs[0].distance.text
                var dur = route.legs[0].duration.text
//                console.log(routeAccidentPoints)
                if(routeAccidentPoints.length === Math.min.apply(null, routes_points)){
                    var color = "#008000"
                } 
                 else {
                    var color = "#c3c5cc"              
                }

                var directionDisplay = new google.maps.DirectionsRenderer({suppressBicyclingLayer: true,suppressMarkers: false, polylineOptions: polylineOptionsActual(color)});

                directionDisplay.setMap(map);

                directionDisplay.setDirections(routeResponse);
                  
                showRouteInfo(route, `Distance: ${dist} \n Time: ${dur}`, index);

              });
                
                
       
                
                
            } else {
              window.alert('Directions request failed due to ' + status);
            }
          });
    };
        
        
 /*       
  
  */      
        
        
               function bikeshare() {
                  
var infowindow = new google.maps.InfoWindow();
          map.data.loadGeoJson(
    'https://data.melbourne.vic.gov.au/resource/vrwc-rwgm.geojson');   
    /*          'https://data.melbourne.vic.gov.au/resource/ru3z-44we.geojson');   */

  // Set the stroke width, and fill color for each polygon

map.data.setStyle({
  icon: 'http://i65.tinypic.com/14shcw3.png',
  fillColor: 'green'
});   
                  
                  
map.data.addListener('click', function(event) {
    
    
    var name = event.feature.getProperty("name");
    var station_id = event.feature.getProperty("station_id");
      var myHTML_capacity = event.feature.getProperty("capacity");
    var rental_method = event.feature.getProperty("rental_method");
    
 var contentString = '<a href="https://www.google.com/" >The address name</a>';
        
 var contentString2 = '<a href="https://awslocals.local/2019/05/05/data-table/" > click here </a>';
    
    
      infowindow.setContent("<div style='width:250px; text-align: center;'>"+name+"<br />" 
                            +" " + "<br />" 
                        //    + "station_id:  "+station_id+"<br />"   
                            +"capacity:  "+myHTML_capacity+"<br />"
                           
                       //     +"check avaliable:  "+"<a href=www.google.com>"+"<br />"
                            +"rental method:  "+rental_method+"<br />"
                            +"</div>");
      infowindow.setPosition(event.feature.getGeometry().get());
      infowindow.setOptions({pixelOffset: new google.maps.Size(0,-30)});
      infowindow.open(map);
  });  
        }
        
        
        
         function toilet() {
    var locations = <?php get_toilet_locations() ?>;  
    
    var red_icon =  'http://i67.tinypic.com/oqk3ew.png' ;
    
    
     var iconBase =
            'https://developers.google.com/maps/documentation/javascript/examples/full/images/';

        var icons = {
          parking: {
            icon: iconBase + 'parking_lot_maps.png'
          },
          library: {
            icon: iconBase + 'library_maps.png'
          },
          info: {
            icon: iconBase + 'info-i_maps.png'
          }
        };
       
 
        for (var i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][0]),
                map: map,
                icon: red_icon
                
            
            });       
        };
          
         }
        
        
        
        
        
         function drinking_fountains() {
    var locations = <?php get_drinking_locations() ?>;  
    
    var red_icon =  'http://i65.tinypic.com/11azl1j.png' ;
    
    
     var iconBase =
            'https://developers.google.com/maps/documentation/javascript/examples/full/images/';

        var icons = {
          parking: {
            icon: iconBase + 'parking_lot_maps.png'
          },
          library: {
            icon: iconBase + 'library_maps.png'
          },
          info: {
            icon: iconBase + 'info-i_maps.png'
          }
        };          
           
          
 
        for (var i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][0]),
                map: map,
                icon: red_icon
                
            
            });       
        };
          
         }
        
        
        
        
        
        
      function addbikelanes() {
          if (bikeLayer.getMap() == null) {
            //bike layer is disabled.. enable it
            bikeLayer.setMap(map);
          } else {
            //bike layer is enabled.. disable it
            bikeLayer.setMap(null);
          }
        }
        
    function addtraffic() {
          if (trafficLayer.getMap() == null) {
            //traffic layer is disabled.. enable it
            trafficLayer.setMap(map);
          } else {
            //traffic layer is enabled.. disable it
            trafficLayer.setMap(null);
          }
        }
 
      function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
      }

      function changeGradient() {
          
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
      }

      function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 20);
      }

        function getPoints2() {
          
          
            var locations = <?php get_confirmed_locations() ?>;  
          
          
            
           var arr = []; 
            
            
           
             for (var i = 0; i < locations.length; i++) {
           var obj = [locations[i][1], locations[i][0]]
                
              
        
            arr.push(obj);
             }
        return arr;
            
        
      }
        
        
        
        
      function changeOpacity() {
          
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
      }
       // var listt = getPoints2();
       
      const accidentPoints = getPoints2();

const distance = (lat1, lon1, lat2, lon2, unit) => {
	if ((lat1 == lat2) && (lon1 == lon2)) {
		return 0;
	}
	else {
		var radlat1 = Math.PI * lat1/180;
		var radlat2 = Math.PI * lat2/180;
		var theta = lon1-lon2;
		var radtheta = Math.PI * theta/180;
		var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
		if (dist > 1) {
			dist = 1;
		}
		dist = Math.acos(dist);
		dist = dist * 180/Math.PI;
		dist = dist * 60 * 1.1515;
		if (unit=="K") { dist = dist * 1.609344 }
		if (unit=="N") { dist = dist * 0.8684 }
		return dist;
	}
}

const getNearestAccidentPointsOnRoute = (route) => {
	return route.overview_path
		.map(path => [ path.lat(), path.lng() ])
		.filter(path => {
			const accidentDistanceMap = accidentPoints.map(point => Math.abs(distance(path[0], path[1], point[0], point[1], "K")));

			const nearestAccidentPoint = Math.min(...accidentDistanceMap);

			return nearestAccidentPoint < 0.01;
		})
}
      // Heatmap data: 500 Points
      function getPoints() {
          
          
            var locations = <?php get_confirmed_locations() ?>;  
          
          
            
           var arr = []; 
            
            
           
             for (var i = 0; i < locations.length; i++) {
           var obj = new google.maps.LatLng(locations[i][1], locations[i][0])
                
              
        
            arr.push(obj);
             }
        return arr;
            
          /*
          
   return [

           
                 new google.maps.LatLng(locations[0][1], locations[0][0]),
               
                 

        ];   */
      }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGCoPCuuV5XyBalMdSpfx8cbQ1SeiMdI4&libraries=visualization,places&callback=initMap">
    </script>

  
<?php get_footer(); ?>