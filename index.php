<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Bigfoot Stats</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Open+Sans:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script type="text/javascript" src="inc/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="inc/chart.js@2.8.0"></script>
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
            <script type="text/javascript" src="map.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=APIKEY&callback=initMap" async defer></script>
        </div>
		
        <!--Chart block-->
        <div id="bigfoot_enviroment" class="col col-1-5 active">
            <h3>Bigfoot's Optimal Enviroment</h3>
            <p class="subheader">Based on Bigfoot Sighting Data</p>
            <nav>
                <ul>
                    <li class="bigfoot_enviroment--charts active">Charts</li>
                    <li class="bigfoot_enviroment--tables">Tables</li>
                </ul>
            </nav>
            <div id="bigfoot_charts" class="active">
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
    </div>
	
    <script>
        
        var label = []; //Array of chart labels
        var count = []; //Array of sightings by tally
		
		// Reusable Ajax function
        function charts(searchValue, orderValue, dirValue, limitValue) {
            return $.ajax({
                type: "POST",
                url: 'bigfoot.php',
                data: {
                    searchValue: searchValue,
                    orderValue: orderValue,
                    dirValue: dirValue,
                    limitValue: limitValue
                },
                success: function(data) {
                    //Clear variables before reassigning.
                    label = [];
                    count = [];
					
					//Sanatize the output
                    label = data.replace(/,\s*$/, "").replace(/['"]+/g, '').split(',');
					//Split the output into 2 arrays.
                    for (var i = label.length - 1; i >= 0; i--) {
                        if (i % 2 === 1) {
                            count.unshift(label.splice(i, 1)[0])
                        }
                    }
                    //console.log(label);
                    //console.log(count);

                },
                error: function(data) {
                    console.log('An error occurred: charts function');
                }

            });
        }
    </script>
	
    <script>
        //ChartJS chart implementation
        Chart.defaults.global.defaultFontFamily = "Open Sans";
        Chart.defaults.scale.gridLines.display = false;

        //Wait until Ajax is finished before excuting this code.	
        $.when(charts("state", "count", "DESC", 10)).done(function() {
            //Create chart based on Ajax output.
            var ctx = document.getElementById('bigfoot_charts--state').getContext('2d');
            var stateChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [{
                        label: 'Sightings by State (1921 - 2018)',
                        data: count,
                        backgroundColor: '#54ecf9',
                        FontFamily: 'Lato'
                    }]
                },
                options: {}
            });
        });

        //Wait until Ajax is finished before excuting this code.
        $.when(charts("year", "year", "ASC", 100)).done(function() {
            //Create chart based on Ajax output.
			var ctx = document.getElementById('bigfoot_charts--year').getContext('2d');
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
                options: {}
            });
        });

        //Loop throgh each of the #bigfoot_tables
        $("#bigfoot_tables div").each(function(index) {

            //Split this class. Use split as parameter for charts function
            var searchValue = $(this).prop("class").split("bigfoot_tables--");

            //Wait until Ajax is finished before excuting this code.
            $.when(charts(searchValue[1], 'count', "DESC", 5)).done(function() {
                //Create table based on Ajax output
                $.each(label, function(key, value) {
                    $(".bigfoot_tables--" + searchValue[1] + " table").append("<tr><td>" + label[key] + "</td><td>" + count[key] + "</td></tr>");
                });
            });
        });

    </script>
	
    <script>		
		
        //Chart or table navigation in right panel
        $("nav ul li").click(function() {
            //remove active class from all
            $("nav ul li, #bigfoot_charts, #bigfoot_tables").removeClass("active");
            //get active parameter
            var activeValue = $(this).prop("class").split("bigfoot_enviroment--");
            //set icon and nav button as active
            $(this).addClass("active");
            $("#bigfoot_" + activeValue[1]).addClass("active");
        });

        //Hide Chart Menu
        $(".chartMenuButton").click(function() {
            $("#bigfoot_enviroment").toggleClass("active");
            $(this).toggleClass("fa-arrow-right").toggleClass("fa-arrow-left");
        });
    </script>
</body>

</html>
