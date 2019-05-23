<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Bigfoot Stats</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700|Open+Sans:400,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="scripts2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
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
                <p>You have a <span>0.001%</span> of seeing a Bigfoot based on your currect location.</p>
            </div>
            <div id="bigfoot_mapping--map"></div>

            <script type="text/javascript" src="scripts2.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=APIKEY&callback=initMap" async defer></script>

        </div>

        <!--Chart block-->
        <div id="bigfoot_enviroment" class="col col-1-5">
            <h3>Bigfoot's Optimal Enviroment</h3>
            <p class="subheader">Based on Bigfoot Sighting Data</p>
            <i class="fas fa-arrow-right" title="Add click functionality to close chart block"></i>
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
        // Ajax reusable function
        var label = [];
        var count = [];

        function charts(searchValue, orderValue, dirValue, limitValue) {
            label = [];
            count = [];
            $.ajax({
                type: "POST",
                url: 'bigfoot.php',
                data: {
                    searchValue: searchValue,
                    orderValue: orderValue,
                    dirValue: dirValue,
                    limitValue: limitValue
                },
                success: function(data) {

                    label = data.replace(/,\s*$/, "").replace(/['"]+/g, '').split(',');
                    for (var i = label.length - 1; i >= 0; i--) {
                        if (i % 2 === 1) {
                            count.unshift(label.splice(i, 1)[0])
                        }
                    }
                    //console.log(label);
                    //console.log(count);

                },
                error: function(data) {
                    $('#notification-bar').text('An error occurred');
                },
                async: false
            });
        }
    </script>

    <script>
        //Loop throgh each of the #bigfoot_tables
        $("#bigfoot_tables div").each(function(index) {

            //Use parameter to pass to charts function
            var searchValue = $(this).prop("class").split("bigfoot_tables--");
            charts(searchValue[1], 'count', "DESC", 5);

            //Use ajax response to create tables
            $.each(label, function(key, value) {
                $(".bigfoot_tables--" + searchValue[1] + " table").append("<tr><td>" + label[key] + "</td><td>" + count[key] + "</td></tr>");
            });

        });

        //Chart Block navigation event
        $("nav ul li").click(function() {
            //remove active class from all
            $("nav ul li, #bigfoot_charts, #bigfoot_tables").removeClass("active");
            //get active parameter
            var activeValue = $(this).prop("class").split("bigfoot_enviroment--");
            //set both as active
            $(this).addClass("active");
            $("#bigfoot_" + activeValue[1]).addClass("active");
        });
    </script>

    <script>
        //Simple ChartJS chart implementation
        Chart.defaults.global.defaultFontFamily = "Open Sans";
        Chart.defaults.scale.gridLines.display = false;

        charts("state", "count", "DESC", 10);
        var ctx = document.getElementById('bigfoot_charts--state').getContext('2d');
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

        charts("year", "year", "ASC", 100);
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
    </script>
</body>

</html>
