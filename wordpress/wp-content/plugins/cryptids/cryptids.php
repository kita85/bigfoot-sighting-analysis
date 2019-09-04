<?php
/**
 * Plugin Name: Cryptids
 * Plugin URI: http://www.kitacranfill.com/Bigfoot
 * Description: Cryptids Map Plugin
 * Version: 1.1
 * Author: Kita Cranfill
 * Author URI: http://www.kitacranfill.com
 */

 
global $cryptids_db_version;
$cryptids_db_version = '1.0';

function cryptids_create_db() {
	global $wpdb;
	global $cryptids_db_version;
	
	$table_name = $wpdb->prefix . 'bigfoot';

	
	if($wpdb->get_var( "show tables like '$table_name'" ) != $table_name) {
		$sql = "CREATE TABLE `". $table_name . "` ( ";
        $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";
        $sql .= "  `type`  varchar(10)   NOT NULL, ";
		$sql .= "  `state`  varchar(50)   NOT NULL, ";
		$sql .= "  `season`  varchar(15)   NOT NULL, ";
		$sql .= "  `title`  varchar(250)   NOT NULL, ";
		$sql .= "  `latitude`  varchar(25)   NOT NULL, ";
		$sql .= "  `longitude`  varchar(25)   NOT NULL, ";
		$sql .= "  `date`  varchar(25)   NOT NULL, ";
		$sql .= "  `year`  year(4)   NOT NULL, ";
		$sql .= "  `number`  varchar(25)   NOT NULL, ";
		$sql .= "  `moon_phase`  varchar(25)   NOT NULL, ";
		$sql .= "  `image`  varchar(35)   NOT NULL, ";
        $sql .= "  PRIMARY KEY `order_id` (`id`) "; 
        $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	

} 
register_activation_hook( __FILE__, 'cryptids_create_db' );

function cryptids_install_data() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'bigfoot';
	
		$wpdb->insert($table_name , array(
			'type' => "Alien",
			'state' => "Tennessee",
			'season' => "Summer" ,
			'title' => "Report 58126: Hikers find possible footprint on a trail in Frozen Head State Park",
			'latitude' => "36.105" ,
			'longitude' => "-84.38335",
			'date' => "8/26/2018" ,
			'year' => "2018",
			'number' => "58126",
			'moon_phase' => "0.51",
			'image' => "Harry.jpg")
		);
}
register_activation_hook( __FILE__, 'cryptids_install_data' ); 
 
function myplugin_scripts() {
   //wp_enqueue_script('jquery', plugin_dir_url(__FILE__) . 'inc/jquery-3.4.1.min.js', array('jquery'), '1.0', true);
   wp_enqueue_script('chartjs', plugin_dir_url(__FILE__) . 'lib/chart.js@2.8.0', '1.0', true);
   wp_enqueue_script('map', plugin_dir_url(__FILE__) . 'src/map.js', array('jquery'), '1.0', true);
   wp_enqueue_script('charts', plugin_dir_url(__FILE__) . 'src/charts.js', array('jquery'), '1.0', true);
   wp_enqueue_script( 'google_js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBcFPiPU-iDyfrTqqkbgDv5_zJmMv5dHow&callback=initMap', array(), '', true);
   wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css', '', '' );
}
add_action( 'wp_enqueue_scripts', 'myplugin_scripts' );



function elegance_referal_init()
{

        $dir = plugin_dir_path( __FILE__ );
        include($dir."inc/upload.php");
		include($dir."templates/index.php");
        die();

}

add_action( 'wp', 'elegance_referal_init' );


function isloggedin()
{
    if ( is_user_logged_in() ) 
    {
		return true;
    }
}



