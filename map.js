//Google Map API implementation
var map;
var sightingJson;

function initMap() {  
	//Create Google map & add Bigfoot sighting data.
    map = new google.maps.Map(document.getElementById('bigfoot_mapping--map'), {
        zoom: 9
    });

    //Load Geo Json File
    map.data.loadGeoJson("inc/bfro_reports.json");

    //Set a new icon
    map.data.setStyle({icon: "images/marker.png"});

    //Add mouseover event to open json data for each sighting marker.
    var sightingInfo = new google.maps.InfoWindow();
    map.data.addListener('click', function(event) {

        var markerName = event.feature.getProperty("name");
        var markerDate = event.feature.getProperty("date");
        var markerSummary = event.feature.getProperty("summary");

        sightingInfo.setContent(markerName + "</br>" + markerDate + "</br>" + markerSummary);
        sightingInfo.setPosition(event.feature.getGeometry().get());
        sightingInfo.open(map);
    });


    //Get HTML5 geolocation if available. *Callback Hell
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            //Set pos to current lat/lng.
            geoSuccess(position);
        }, function() {
            //Couldnt find geolocation. Manually set user marker.
            geoFail();
        });
    } else {
        // Browser doesn't support Geolocation. Manually set user marker.
        geoFail();
    }
}

function geoSuccess(position) {
    //Set pos to current lat/lng.	
    var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    userLocation(pos);
}

function geoFail() {
    //Couldn't find geolocation. Manually set user marker.
    var pos = new google.maps.LatLng({lat: 36.0104,lng: -84.2696});
    userLocation(pos);
}


function userLocation(pos) {
    //Add marker at currect location then center map.
    var userMarker = new google.maps.Marker({
        position: pos,
        map: map,
        draggable: true
    });
    map.setCenter(pos);

    //Call radius function: Add radius around currect location.	
    radius(pos);

    //Add info window (tool tip) to explain user can drag location marker.
    var dragme = new google.maps.InfoWindow({
        content: "I'm Draggable!"
    });
    dragme.open(map, userMarker);

    //Listen for current location marker drag event end. Update lat/lng, redraw radius, & probability.
    google.maps.event.addListener(userMarker, 'dragend', function() {
        pos = userMarker.getPosition();
        radius_circle.setMap(null);
        radius(pos);
        probability(pos, sightingJson);
    });
	
	//Assign json to variable then call probablity function.
	$.getJSON("inc/bfro_reports.json", function(data) {
        sightingJson = data["features"];
        probability(pos, sightingJson);
    });

}

function radius(pos) {
    //Add radius around currect location.		
    radius_circle = new google.maps.Circle({
        center: pos,
        radius: 50 * 1000, //km to meters
        clickable: false,
        map: map
    });
}


function probability(pos, sightingJson) {
    //Probably is based on random chance * area sightings * proximity to current location
    //*Other factors to implement in order to create more accerate probability: date, weather, season, tempature, terrain
    var randomChance = 0.0000000715; //Chances of winning the lottery
    var proximity = 0;
    var areaSightings = 0;

    //Loop through all sightings lat/lng
    for (var i = 0; i < sightingJson.length; i++) {
        var checkcord = new google.maps.LatLng(sightingJson[i]["geometry"]["coordinates"][1], sightingJson[i]["geometry"]["coordinates"][0]);

        //Find distance between sighting and currect lat/lng.
        var distance_from_location = google.maps.geometry.spherical.computeDistanceBetween(pos, checkcord);

        //If distance is less than 50000 meters, do some arbitrary math.
        if (distance_from_location <= 50 * 1000) {
            areaSightings++;
            proximity = proximity + distance_from_location;
        }
    }

    //If location radius has sightings, do probablity math. Otherwise, it is random change.
    if (areaSightings != 0) {
        var probablity = randomChance * (areaSightings * 10) * (proximity / areaSightings * 10);
    } else {
        var probablity = randomChance; //Never an absolute 0 chance of seeing Bigfoot!
    }
    $("#bigfoot_mapping--proximity span").text(probablity.toFixed(8) + "%");
}
