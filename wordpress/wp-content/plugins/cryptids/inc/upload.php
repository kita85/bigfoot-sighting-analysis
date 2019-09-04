<?php
/** FIND BEST PRACTICE */
//include wp-config or wp-load.php
$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
require_once($root . '/wp-admin/includes/image.php');
require_once($root . '/wp-admin/includes/file.php');
require_once($root . '/wp-admin/includes/media.php');

if (file_exists($root . '/wp-load.php')) {
    // WP 2.6
    require_once($root . '/wp-load.php');
} else {
    // Before 2.6
    require_once($root . '/wp-config.php');
}

//Add sanitization
$bf_type       = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
$bf_state      = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
$bf_season     = filter_var($_POST['season'], FILTER_SANITIZE_STRING);
$bf_title      = filter_var($_POST['title'], FILTER_SANITIZE_STRING); 
$bf_latitude   = filter_var($_POST['latitude'], FILTER_SANITIZE_STRING);
$bf_longitude  = filter_var($_POST['longitude'], FILTER_SANITIZE_STRING);
$bf_date       = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
$bf_year       = filter_var($_POST['year'], FILTER_SANITIZE_STRING);
$bf_number     = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
$bf_moon_phase = filter_var($_POST['moon_phase'], FILTER_SANITIZE_STRING);

?>

<?php

if (isset($_POST['submit'])) {
    
	//If submission is Bigfoot sighting OR the user is logged in
    if ($bf_type === "Bigfoot" || is_user_logged_in()) {
        
        
        $imageurl = "";
        //Add file to uploads dir
        if ($_FILES['file']['name'] != '') {
            $uploadedfile     = $_FILES['file'];
            $upload_overrides = array(
                'test_form' => false
            );
            
            $movefile = wp_handle_upload($uploadedfile, $upload_overrides);
            
            if (isset($movefile['error'])) {
                echo "<div class='info_bar'><i class='fas fa-exclamation-circle'></i><strong>Server Message:</strong> Image Error " . $movefile['error'] . "</div>";
            } else {
				//Split the path so that only part of the url is stored in the database
                $imageurl = (explode("wp-content", $movefile['url']));
                $imageurl = $imageurl[1];
				console.log($movefile['url']);
            }
        }
        
        //Connect to database
        global $wpdb;
        $table_name = $wpdb->prefix . 'bigfoot';
        
		//Submit form results to custom bigfoot table
        $result = $wpdb->insert($table_name, array(
            'type' => $bf_type,
            'state' => $bf_state,
            'season' => $bf_season,
            'title' => $bf_title,
            'latitude' => $bf_latitude,
            'longitude' => $bf_longitude,
            'date' => $bf_date,
            'year' => $bf_year,
            'number' => $bf_number,
            'moon_phase' => $bf_moon_phase,
            'image' => $imageurl
        ));
		
	

		// Quick check to see if URL already has a parameter
		if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY)) {
			$url .= '&';
		} else {
			$url .= '?';
		}
		
        if ($result === FALSE) {
			
            //Error
			$get_status = $url."status=error";
			
			//This fixes the form from being resubmitted on page refresh
			header("Location: " . $_SERVER['REQUEST_URI'].$get_status);
			exit();
        } else {
            //Success
			$get_status = $url."status=success";
            header("Location: " . $_SERVER['REQUEST_URI'].$get_status);
			exit();		
        }
    } else {
		//Login to Submit
		$get_status = $url."status=login";
		header("Location: " . $_SERVER['REQUEST_URI'].$get_status);
	    exit();
	}
}

?>
<?php get_header(); ?>
 <!--Add Sighting block-->
  <div id="add_sighting">
    <h3>Tell Us About Your Sighting</h3>
    <p class="subheader">*Please login to submit Alien Sightings</p>
       <div class="add_sighting--form">

        <!-- Form -->
        <form method='post' enctype='multipart/form-data'>
                  <label for="type">Sighting Type</label>
                  <input type="radio" name="type" value="Alien"> Alien
                  <input type="radio" name="type" value="Bigfoot" checked> Bigfoot<br><br>
                  
                  <label for="state">State</label>
                  <input type="text" name="state" value="Tennessee"><br>
                  
                  <label for="season">season</label>
                  <input type="text" name="season" value="Summer"><br>
                  
                  <label for="title">title</label>
                  <input type="text" name="title" value="Short Description"><br>
                  
                  <label for="latitude">latitude</label>
                  <input type="text" name="latitude" value="36.105"><br>
                  
                  <label for="longitude">longitude</label>
                  <input type="text" name="longitude" value="-84.38335"><br>
                  
                  <label for="date">date</label>
                  <input type="text" name="date" value="8/26/2018"><br>
                  
                  <label for="year">year</label>
                  <input type="text" name="year" value="2018"><br>
                  
                  <label for="number">number</label>
                  <input type="text" name="number" value="58126"><br>
                  
                  <label for="moon_phase">moon_phase</label>
                  <input type="text" name="moon_phase" value="0.51"><br>
                  
                  <label for="image">Upload Picture</label>
                  <input type='file' name='file'><br><br>

                  <input type='submit' name='submit' value='Submit'>
        </form>

    </div>
</div>
