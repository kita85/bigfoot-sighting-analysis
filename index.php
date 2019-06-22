<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Bigfoot Stats</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Open+Sans:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="inc/jquery-3.4.1.min.js"></script>
    <script src="inc/chart.js@2.8.0"></script>
	<script src="src/charts.js"></script>
</head>

<body>
    <div class="wrapper">
	
        <!--Profile block-->
        <div id="bigfoot">
            <div class="bigfoot--image"></div>
        </div>
		

		
        <!--Map block-->
        <div id="bigfoot_mapping" class="col col-4-5">
            <div id="bigfoot_mapping--proximity">
                <i class="fas fa-info-circle"></i>
                <p>Geo Message | </p>
                <p>You have a <span>0.000%</span> of seeing a Bigfoot based on your currect location.</p>
                <i class="chartMenuButton fas fa-arrow-right" title="Hide Chart Menu"></i>
            </div>
            <div id="bigfoot_mapping--map"></div>
            <!--Google Map API-->
            <script src="src/map.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=APIKEY&callback=initMap" async defer></script>
			
	   </div>
		
        <!--Chart block-->
        <div id="bigfoot_enviroment" class="col col-1-5 active">
            <h3>Bigfoot's Optimal Enviroment</h3>
            <p class="subheader">Based on Bigfoot Sighting Data</p>
            <nav>
                <ul>
                    <li class="bigfoot_enviroment--search active">Map Controls</li>
					<li class="bigfoot_enviroment--charts">Charts</li>
                    <li class="bigfoot_enviroment--tables">Tables</li>
                </ul>
            </nav>
			<div id="bigfoot_search" class="active">			
				<!--Input Popup-->
				<div class="bigfoot--map_controls">
				   <form>
					  <input id="ilat" type="text" name="lat" placeholder="Latitude">
					  <input id="ilng" type="text" name="long" placeholder="Longitude">
					  <input type="submit" value="Submit">
					</form>
				</div>
			</div>
            <div id="bigfoot_charts">
                <div class="bigfoot_charts_container">
                    <canvas id="bigfoot_charts--state" width="300" height="300"></canvas>
                </div>
                <div class="bigfoot_charts_container">
                    <canvas id="bigfoot_charts--year" width="300" height="300"></canvas>
                </div>
            </div>
            <div id="bigfoot_tables">
                <div class="bigfoot_tables--season">
                    <table>
                        <tr>
                            <th>Season</th>
                            <th># of Sightings</th>
                        </tr>
                    </table>
                </div>
                <div class="bigfoot_tables--temperature_mid">
                    <table>
                        <tr>
                            <th>Mid Temperature</th>
                            <th># of Sightings</th>
                        </tr>
                    </table>
                </div>
                <div class="bigfoot_tables--moon_phase">
                    <table>
                        <tr>
                            <th>Moon Phase</th>
                            <th># of Sightings</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- end wrapper -->
</body>

</html>
