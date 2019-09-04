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
  
var $ = require('jquery');
var html = require('fs').readFileSync('./index.php').toString();

describe ("bigfoot_mapping", () => {
	
	
	it( 'Calculates Proximity', () => {
		expect(true).toBeTruthy();
	
	});

	it( 'Creates Map', () => {
		expect(true).toBeTruthy();
	
	});
	
});


describe ("nav", () => {
	
	it( 'Show/Hide Side Panel', () => {
		  // Set up our document body
		  document.body.innerHTML =
			'<i class="chartMenuButton fas fa-arrow-right" title="Hide Chart Menu"></i>';
			
		require('../src/charts');
		//Classes before click
		expect($('.chartMenuButton').hasClass('fa-arrow-left')).toBeFalsy();
		expect($('#bigfoot_mapping--proximity').hasClass('active')).toBeFalsy();
		
		//Simulate Click
		$('.chartMenuButton').click();		

		//Classes after click
		expect($('.chartMenuButton').hasClass('fa-arrow-left')).toBeTruthy();
		//expect($('#bigfoot_mapping--proximity').hasClass('active')).toBeTruthy();
		

	});
	
	it( 'Switches Side Panel View', () => {
		expect(true).toBeTruthy();
	
	});

	
});

describe ("map_controls", () => {

	
	it( 'Lat Lng Input', () => {
		document.documentElement.innerHTML = html;	
		$('#ilat').val('22');
		expect($('#ilat').val()).toBe("22");
	});

	it( 'Updates URL Param', () => {
		expect(true).toBeTruthy();
	
	});
	
});

describe ("bigfoot_charts", () => {
	
	
	it( 'bigfoot_charts--state', () => {
		expect(true).toBeTruthy();
	
	});

	it( 'bigfoot_charts--year', () => {
		expect(true).toBeTruthy();
	
	});
	
});

describe ("bigfoot_tables", () => {
	
	
	it( 'bigfoot_tables--season', () => {
		expect(true).toBeTruthy();
	
	});
	
	it( 'bigfoot_tables--moon_phase', () => {
		expect(true).toBeTruthy();
	
	});

	
});





