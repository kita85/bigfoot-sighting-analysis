<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width">
      <title>Bigfoot Stats</title>
      <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Open+Sans:400,600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="styles.css">
      <script type="text/javascript" src="scripts.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
   </head>
   <body>
      <header>
         <p>Kita Cranfill's Bigfoot Analysis</p>
      </header>
      <div class="wrapper">
         <div id="bigfoot" class="">
            <div class="profile_pic"></div>
         </div>
         <div id="bigfoot_mapping--map" class="col col-4-5">
            <div id="bigfoot_mapping--proximity"  class="">
               <p class="fas fa-info-circle">Geo Message | </p>
               <p>You have a <span class="bigfoot_stats--proximity">0.001%</span> of seeing a Bigfoot based on your currect location.</p>
            </div>
            <img src="map.png">
            <div id="map"></div>
            <script>
               var map;
               function initMap() {
               map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 36.0104, lng: -84.2696},
                zoom: 8
               });
               
               
               
               map.data.loadGeoJson('bfro_reports.json');
               
               var image = {
               url: "marker.png"
               };
               map.data.setStyle({
                icon: image
               });
               
               // Set mouseover event for each feature.
               map.data.addListener('mouseover', function(event) {
               document.getElementById('bigfoot_mapping--proximity').textContent =
                event.feature.getProperty('name');
               });
               
               
               infoWindow = new google.maps.InfoWindow;
                     // Try HTML5 geolocation.
                  if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                      var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                      };
               
                      infoWindow.setPosition(pos);
                      infoWindow.setContent('Location found.');
                      infoWindow.open(map);
                      map.setCenter(pos);
                    }, function() {
                      handleLocationError(true, infoWindow, map.getCenter());
                    });
                  } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                  }
               
               
               }
            </script>
            <!--<script src="https://maps.googleapis.com/maps/api/js?key=APIKEY&callback=initMap" async defer></script>-->
         </div>
         <div id="bigfoot_enviroment" class="col col-1-5">
            <h3>Bigfoot's Optimal Enviroment</h3>
            <p class="subheader">Based on Bigfoot Sighting Data</p>
            <i class="fas fa-arrow-right"></i>
            <nav>
               <ul>
                  <li class="bigfoot_enviroment--charts active">Charts</li>
                  <li class="bigfoot_enviroment--tables">Tables</li>
               </ul>
            </nav>
            <div class="bigfoot_charts active">
               <div class="map-container">
                  <canvas id="stateChart" width="400" height="400"></canvas>
               </div>
               <div class="map-container">
                  <canvas id="yearChart" width="400" height="400"></canvas>
               </div>
            </div>
            <div class="bigfoot_tables">
               <div class="bigfoot_tables--season"></div>
               <div class="bigfoot_tables--temperature_mid"></div>
               <div class="bigfoot_tables--moon_phase"></div>
            </div>
         </div>
      </div>
	  
	  <!--AJAX CODE SAMPLE-->
      <script>
         var label = [];
         var count = [];
         
         	function charts(searchValue) {
         	  $.ajax({
         		   type: "POST",
         		   url: 'bigfoot.php',
         		   data:{searchValue:searchValue},
         		   success:function(data) {
         
         			   label = data.trim(",").replace(/['"]+/g, '').split(',');
         				  for(var i = label.length-1; i >= 0; i--) {
         				  if(i % 2 === 1) {
         					count.unshift(label.splice(i, 1)[0])
         				  }
         				}
         				//console.log(label);
         				//console.log(count);
         
         		   }, 
         			async: false
         	  });			   
           }
         
      </script>
      <script>
         //Loop and query my table data
         $( ".bigfoot_tables div" ).each(function( index ) {
         	var searchValue = $(this).prop("class").split("bigfoot_tables--");
         	charts(searchValue[1]);
         	$(this).append("<p class='bigfoot_enviroment_title'>"+searchValue[1]+"</p><ul>");
         	$.each( label, function( key, value ) {
         		$(".bigfoot_tables--"+searchValue[1]+" ul").append("<li>"+label[key]+" "+count[key]+"</li>");
         	});
         	$(this).append("</ul>");
         });
         $("nav ul li").click(function() {
           $("nav ul li, .bigfoot_charts, .bigfoot_tables").removeClass("active");
           var activeValue = $(this).prop("class").split("bigfoot_enviroment--");
           $(this).toggleClass("active");
           $(".bigfoot_"+activeValue[1]).toggleClass("active");
         });
      </script>
      <script>
         //ChartJS chart implementation
         charts("state");
         var ctx = document.getElementById('stateChart').getContext('2d');
         var stateChart = new Chart(ctx, {
         	type: 'bar',
         	data: {
         		labels: label,
         		datasets: [{
         			label: 'Sightings by State (1950 - 2015)',
         			data: count,
         			backgroundColor: '#54ecf9',
         			FontFamily: 'Lato'
         		}]
         	},
         	options: {}
         });
         
         charts("year");
         var ctx = document.getElementById('yearChart').getContext('2d');
         var yearChart = new Chart(ctx, {
         	type: 'line',
         	data: {
         		labels: label,
         		datasets: [{
         			label: 'Sightings by Year',
         			data: count,
         			backgroundColor: '#f95454',
         			borderColor: '#f95454',
         			fill: false,
         			lineTension: 0
         		}]
         	},
         	options: {
         	}
         });
      </script>
   </body>
</html>
