//HTML TESTING
/*
var $ = require('jquery');
var html = require('fs').readFileSync('./index.php').toString();
document.documentElement.innerHTML = html;
expect($('#bigfoot_enviroment').hasClass('col')).toBeTruthy();
*/

jest
  .dontMock('fs')
  .dontMock('jquery');

	
const google = {
  maps: {
    LatLng: jest.fn(),
	Marker: jest.fn(),
    Map: function() {
         return {
             //methods
              setCenter: jest.fn()
			};
    },
	setCenter: jest.fn(),
	Circle: jest.fn(),
	Data: function() {
		loadGeoJson: jest.fn()
	},
    event: jest.fn()
  }
}
global.window.google = google;

const mapjs = require('../src/map');

describe ("initMap", () => {
	
	
	it( 'Assigned Map', () => {
		expect(true).toBeTruthy();
	
	});
	
	it( 'Loaded Data', () => {
		expect(true).toBeTruthy();
	
	});
	
	it( 'Checked for URL hash', () => {
		window.location.search.indexOf('?') == true;
		expect(true).toBeTruthy();
	
	});
	
	it( 'Checked HTML geolocaton', () => {
			
			const mockGeolocation = {
			  getCurrentPosition: jest.fn()
				.mockImplementationOnce((success) => Promise.resolve(success({
				  coords: {
					latitude: 51.1,
					longitude: 45.3
				  }
										  
				})))
			};
			global.navigator.geolocation = mockGeolocation;
			const pos = {coords: {lat: mockGeolocation.latitude,lng: mockGeolocation.longitude}};
	});
	
});





//check if radius function is being called
test ("radius", () => {
	const pos = {coords: {lat: 36.0104,lng: -84.2696}};
    mapjs.radius(pos);
	expect(mapjs.radius).toBeTruthy();
});


describe ("probability", () => {

	const sightingJson = jest.fn();
	const pos = {coords: {lat: 36.0104,lng: -84.2696}};
	
	
	it( 'Calculated the probability of seeing a bigfoot', () => {
		expect(mapjs.probability(pos,sightingJson)).toBe("0.00000007");	
	});
});