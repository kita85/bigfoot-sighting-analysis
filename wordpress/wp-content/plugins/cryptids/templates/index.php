<?php
/**
 * The template for displaying interactive map
 *
 * @package WordPress
 * @subpackage Cryptids
 * @since 1.0.0
 */


?>
<div class="wrapper">
   <!--Profile block-->
   <div id="bigfoot">
      <div class="bigfoot--image"></div>
      <i class="fas fa-plus"></i>
   </div>
   <!--Map block-->
   <div id="bigfoot_mapping" class="col col-4-5">
      <div id="bigfoot_mapping--proximity">
         <i class="fas fa-info-circle"></i>
         <p>Geo Message | </p>
         <p>You have a <span>0.000%</span> of seeing a Bigfoot or Alien based on your currect location.</p>
         <i class="chartMenuButton fas fa-arrow-right" title="Hide Chart Menu"></i>
      </div>
      <div id="bigfoot_mapping--map"></div>
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
            <p>By Selecting a location on the map, the <strong>Geo Message</strong> at the top of the page will display your chances of seeing a Bigfoot at that location.</p>
            <form>
               <label>Radius</label><br>
               <input id="iradius" type="range" step="10000" min="10000" max="100000" value="10000"onchange="updateRadius(iradius.value)"></br></br>
               <label>Filter Sighting Type</label><br>
               <input type="checkbox" name="filtertype" value="Bigfoot" checked> Bigfoot<br>
               <input type="checkbox" name="filtertype" value="Alien" checked> Alien<br>
            </form>
            <form>
               <fieldset>
                  <legend>Search by:</legend>
                  <label> Zip Code</label><br>
                  <input id="izip" type="number" name="zip" >
                  <p>or by</p>
                  <label>Latitude</label>
                  <input id="ilat" type="number" name="lat" max="70" min="22" step="0.00000000000001" /><br><br>
                  <label>Longitude</label>
                  <input id="ilng" type="number" name="long" smax="-65" min="-170" step="0.00000000000001" />
                  <input type="submit" value="Submit">
               </fieldset>
            </form>
			<div class="testing">
				<h3>Lat/Lng for Testing:</h3>
				<p>35.95800098490439</p>
				<p>-83.92456029687503</p>
				<br>
				<p>36.02688043496123</p>
				<p>-84.68605939296873</p>
				<br>
				<p>36.28411399050</p>
				<p>-84.4278510820</p>
			</div>
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

	<div class='info_bar error'><i class='fas fa-exclamation-circle'></i><strong>Server Message:</strong> Submission Error</div>
	<div class='info_bar success'><i class='fas fa-exclamation-circle'></i><strong>Server Message:</strong> Sighting Successfully Added</div>
	<div class='info_bar login'><i class='fas fa-exclamation-circle'></i><strong>Server Message:</strong> Please <a href='/wp-login.php' title='Members Area Login' rel='home'>login</a> to add Alien Sighting.</div>
</div>
<!-- end wrapper -->

<script>
   jQuery(document).ready(function() {
       
       //ChartJS chart implementation
       Chart.defaults.global.defaultFontFamily = "Open Sans";
       Chart.defaults.scale.gridLines.display = false;
   
       //Call function that pushes objects to array
       chartQuery("state", "count", "DESC", 10);
       chartQuery("year", "year", "ASC", 100);
       
       //Loop throgh each of the HTML #bigfoot_tables
       jQuery("#bigfoot_tables div").each(function(index) {
   
           //Split this class. Use split as parameter for charts function
           var searchValue = jQuery(this).prop("class").split("bigfoot_tables--");
           chartQuery(searchValue[1], searchValue[1], "ASC", 10);
   
       });
   
   
       //Chart or table navigation in right panel
       jQuery("nav ul li").click(function() {
           //remove active class from all
           jQuery("nav ul li, #bigfoot_search, #bigfoot_charts, #bigfoot_tables").removeClass("active");
           //get active parameter
           var activeValue = jQuery(this).prop("class").split("bigfoot_enviroment--");
           //set icon and nav button as active
           jQuery(this).addClass("active");
           jQuery("#bigfoot_" + activeValue[1]).addClass("active");
       });
   
       //Hide Chart Menu
       jQuery(".chartMenuButton").click(function() {
           jQuery("#bigfoot_enviroment, #bigfoot_mapping--proximity").toggleClass("active");        
           jQuery(this).toggleClass("fa-arrow-right").toggleClass("fa-arrow-left");
       });
       
       //Open Add Sighting Menu
       jQuery("#bigfoot .fa-plus").click(function() {
           jQuery("#add_sighting").toggle();        
           jQuery(this).toggleClass("fa-plus").toggleClass("fa-minus");
       });
       
       
       //Change Sighting Filter
       jQuery("input[name='filtertype']").change(function() {
           var filter = jQuery('input[name="filtertype"]:checked').map(function() {
               return this.value;
           }).get();
           console.log(filter);
           filterMarkers(filter);
       });
       
	   //Control Info Bar with status parameter
	   if (window.location.search.indexOf('status') > -1) {
			var status = (location.search.split('status' + '=')[1] || '').split('?')[0];
			jQuery(".info_bar."+status).show().delay(5000).fadeOut();
	   }
	   
       
   });
</script>
<?php
get_footer();