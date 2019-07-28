/*
Google Map Api tests would also be required for a realistic implementation. 
Below are DOM and AJAX tests to meet the needs of this sample.
*/

//Test probablity text.
describe("bigfoot_mapping", () => {

    it('Calculates Proximity', () => {
		//Load html to be tested
        loadFixtures('index.html');
        expect($('#bigfoot_mapping--proximity p span').text()).toBe("0.000%");

        var probablity = 0.0000000715;

        $("#bigfoot_mapping--proximity span").text(probablity.toFixed(8) + "%");
        expect($('#bigfoot_mapping--proximity p span').text()).toBe("0.00000007%");

    });


});


//Test class changes on nav when click is triggered.
describe("nav", () => {

    it('Show/Hide Side Panel', () => {
        //Load html to be tested
        loadFixtures('index.html');

        //Classes before click
        expect($('.chartMenuButton').hasClass('fa-arrow-left')).toBeFalsy();
        expect($('#bigfoot_mapping--proximity').hasClass('active')).toBeFalsy();

        var spyEvent = spyOnEvent('.chartMenuButton', 'click')

        //Simulate Click
        $('.chartMenuButton').click();
        expect(spyEvent).toHaveBeenTriggered();

        //Classes after click
        expect($('.chartMenuButton').hasClass('fa-arrow-left')).toBeTruthy();
        expect($('#bigfoot_mapping--proximity').hasClass('active')).toBeTruthy();

    });

    it('Switches Side Panel View', () => {
        //Load html to be tested
        loadFixtures('index.html');

        //Default "search" panel is visible
        expect($('#bigfoot_search').hasClass('active')).toBeTruthy();
        expect($('#bigfoot_charts').hasClass('active')).toBeFalsy();
        expect($('#bigfoot_tables').hasClass('active')).toBeFalsy();

        //Simulate Click
        $('.bigfoot_enviroment--charts').click();

        //New "charts" panel view is visible
        expect($('#bigfoot_charts').hasClass('active')).toBeTruthy();

    });


});

//Test Lat/Lng inputs
describe("map_controls", () => {


    it('Lat Lng Input', () => {
        //Load html to be tested
        loadFixtures('index.html');

        $('#ilat').val('22');
        $('#ilng').val('aa');

        expect($('#ilat').val()).toMatch(/\d{1,}/);
        expect($('#ilng').val()).not.toMatch(/\d{1,}/);
    });


});


//Check if Charts are being created
describe("bigfoot_charts", () => {
    
	beforeEach(function() {
        //Load html to be tested
        loadFixtures('index.html');
        //Install Ajax			
        jasmine.Ajax.install();
    });

    afterEach(function() {
        //Uninstall Ajax
        jasmine.Ajax.uninstall();
    });

	
    it('State = true', () => {			
	 
	 //Mock Ajax
	  spyOn($, 'ajax');
	  
	  //Feed it expected output.
	  var dataArray = ["Tennessee","1"];
	  var myJSON = JSON.stringify(dataArray);
	  
	  //Call Ajax function with fake output
	  chartQuery("state");
	  $.ajax.calls.mostRecent().args[0].success(myJSON);
	  expect($.ajax).toHaveBeenCalled();

	  //Ajax success causes "state" chart to be created.
	  expect('canvas#bigfoot_charts--state.chartjs-render-monitor').toExist();

	});

    it('Year != true', () => {
		
		//Did not call ajax for "year". Therefore "year" chart should not exist.
        expect('canvas#bigfoot_charts--year.chartjs-render-monitor').not.toExist();

    });



});


//Check if Tables are being created
describe("bigfoot_tables", () => {


    it('Season = true', () => {
		//Load html to be tested
        loadFixtures('index.html');
		
		//Add extra table rows to simulate successful ajax response.
		$(".bigfoot_tables--season table").append("<tr><td>Winter</td><td>1</td></tr>");
		
		//Table expected to have 2 rows. 
        expect($('.bigfoot_tables--season table tr').length).toBeGreaterThan(1);
    });

    it('Moon Phase != true', () => {
		//Load html to be tested
        loadFixtures('index.html');

		//Table expected to have 1 row because we did not simulate successful ajax response for moon_phase.
        expect($('.bigfoot_tables--moon_phase table tr').length).toEqual(1);
    });


});