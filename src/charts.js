/**
 * @fileOverview Google Map API implementation
 * @author Kita Cranfill
 * @version 1.0.0
 * @module lib/maps
 */
var map;
var sightingJson;


/**
 * Creates a map with Bigfoot sighting data. Also asks user permission to use HTML5 geolocation
 * @example
 *
 *  map.data.loadGeoJson("inc/bfro_reports.json");
 * @see https://developers.google.com/maps/documentation/javascript/tutorial
 * @memberof module:lib/maps
 */
function initMap() {
    map = new google.maps.Map(document.getElementById('bigfoot_mapping--map'), {
        zoom: 9
    });

    //Load Geo Json File
    map.data.loadGeoJson("inc/bfro_reports.json");

    //Set a new icon
    map.data.setStyle({
        icon: "images/marker.png"
    });

    //Add mouseover event to open json data for each sighting marker.
    var sightingInfo = new google.maps.InfoWindow();
    map.data.addListener('click', function(event) {

        var markerName = event.feature.getProperty("name");
        var markerDate = event.feature.getProperty("date");
        var markerSummary = event.feature.getProperty("summary");

        sightingInfo.setContent("<strong>Case #:</strong> " + markerName + "</br>" + markerDate + "</br>" + markerSummary);
        sightingInfo.setPosition(event.feature.getGeometry().get());
        sightingInfo.open(map);
    });

	//Get URL parmeters if available.
	if (window.location.search.indexOf('?') > -1) {
		var parameters = window.location.toString().split("?");
		parameters = parameters[1].split("&");
		var ilat = parameters[0].split("=");
		var ilng = parameters[1].split("=");
		
		//***Add error handling
		ilat = Number(ilat[1]);
		ilng = Number(ilng[1]);
		
		var pos = new google.maps.LatLng({lat: ilat,lng: ilng});

		userLocation(pos);
	} else {
		//Else get HTML5 geolocation if available.
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				//Set pos to current lat/lng.
				var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);				
				userLocation(pos);
				//geoSuccess(position);
			}, function() {
				//Couldnt find geolocation. Manually set user marker.
				geoFail();
			});
		} else {
			// Browser doesn't support Geolocation. Manually set user marker.
			geoFail();
		}
	}
}




/**
 * Browser could not obtain geolocation. Manually set user coordinates.
 * @memberof module:lib/maps
 */
function geoFail() {
    var pos = new google.maps.LatLng({
        lat: 36.0104,
        lng: -84.2696
    });
    userLocation(pos);
}




/**
 * Adds marker at coordinates. Also adds event listener for marker drag then calls probability().
 * @param {Object} pos - Google Map coordinates for marker.
 * @memberof module:lib/maps
 */
function userLocation(pos) {
    $("#ilat").val(pos.lat); //add parameters to lat input
    $("#ilng").val(pos.lng); //add parameters to lng input
	
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
        $("#ilat").val(pos.lat); //add parameters to lat input
		$("#ilng").val(pos.lng); //add parameters to lng input
		radius_circle.setMap(null);
        radius(pos);
        probability(pos, sightingJson);
    });

    //Assign json to variable then call probablity function.
    $.getJSON("inc/bfro_reports.json", function(data) {
        sightingJson = data["features"];
        probability(pos, sightingJson);
    });
    return;
}




/**
 * Add radius around coordinates.
 * @param {Object} pos - Google Map coordinates for marker.
 * @memberof module:lib/maps
 */
function radius(pos) {
    radius_circle = new google.maps.Circle({
        center: pos,
        radius: 50 * 1000, //km to meters
        clickable: false,
        map: map
    });
    return;
}




/**
 * Probably is based on random chance, area sightings, and proximity to current location.
 * @example
 *
 *  if (areaSightings != 0) {
    var probablity = randomChance * (areaSightings * 10) * (proximity / areaSightings * 10);
 } else {
    var probablity = randomChance; //Never an absolute 0 chance of seeing Bigfoot!
}
 * @param {Object} pos - Google Map coordinates for marker.
 * @param {Object} sightingJson - The Bigfoot sighting json
 * @returns {number} - The probability of seeing a Bigfoot.
 * @memberof module:lib/maps
 */
function probability(pos, sightingJson) {
    //Other factors to implement in order to create more accerate probability: date, weather, season, tempature, terrain.
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
        probablity = randomChance * (areaSightings * 10) * (proximity / areaSightings * 10);
    } else {
        probablity = randomChance; //Never an absolute 0 chance of seeing Bigfoot!
    }
       
       $("#bigfoot_mapping--proximity span").text(probablity.toFixed(8) + "%");
	   return probablity.toFixed(8);
}
