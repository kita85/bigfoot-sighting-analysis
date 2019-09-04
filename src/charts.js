/**
 * @fileOverview ChartJS implementation and DOM manipulation 
 * @author Kita Cranfill
 * @version 1.0.0
 * @module lib/charts
 */
var label = []; //Array of chart labels
var count = []; //Array of sightings by tally
var chartObjs = [];

/**
 * Reusable Ajax function that queries the database and displays charts.
 * @example
 *
 * chartQuery("state", "count", "DESC", 10);
 * @param {string} searchValue - Row to be queried 
 * @param {string} orderValue - Which variable to order data by.
 * @param {string} dirValue - (ASC or DESC) order by direction
 * @param {number} limitValue - Limit the number of results in query.
 * @memberof module:lib/charts
 */
function chartQuery(searchValue, orderValue, dirValue, limitValue) {

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

            //Switch case to draw specific charts based on search value
            switch (searchValue) {
                case "state":
                    chartState(label, count);
                    break;

                case "year":
                    chartYear(label, count);
                    break;

                case "season":
                    tables(searchValue, label, count);
                    break;


                case "moon_phase":
                    tables(searchValue, label, count);
                    break;
            }

        },
        error: function(data) {
            console.log('An error occurred: charts function');
        }

    });

}




/**
 * Create chart based on Ajax output.
 * @param {string} label - States available in dataset.
 * @param {number} count - Number of times this label has been counted in the database.
 * @memberof module:lib/charts
 */
function chartState(label, count) {
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

}


/**
 * Create year chart based on Ajax output.
 * @param {string} label - Years available in dataset.
 * @param {number} count - Number of times this label has been counted in the database.
 * @memberof module:lib/charts
 */
function chartYear(label, count) {
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


}

/**
 * Fill in tables based on Ajax output
 * @param {string} label - Research Parameter available in dataset.
 * @param {number} count - Number of times this label has been counted in the database.
 * @memberof module:lib/charts
 */
function tables(searchValue, label, count) {
    $.each(label, function(key, value) {
        $(".bigfoot_tables--" + searchValue + " table").append("<tr><td>" + label[key] + "</td><td>" + count[key] + "</td></tr>");
    });
}