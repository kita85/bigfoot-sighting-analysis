<?php
/** FIND BEST PRACTICE */
//include wp-config or wp-load.php
$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
if (file_exists($root . '/wp-load.php')) {
    // WP 2.6
    require_once($root . '/wp-load.php');
} else {
    // Before 2.6
    require_once($root . '/wp-config.php');
}


//Connect to database
global $wpdb;
$table_name = $wpdb->prefix . 'bigfoot';

//Query all rows
$result = $wpdb->get_results("SELECT * from " . $table_name);

//Add GeoJSON structure
$geojson = array(
    'type' => 'FeatureCollection',
    'features' => array()
);

//Add row data as GeoJSON properties, etc.
foreach ($result as $row) {
    $row = get_object_vars($row);
    if (is_numeric($row['latitude']) || is_numeric($row['longitude'])) {
        $properties = $row;
        unset($properties['longitude']);
        unset($properties['latitude']);
        $feature = array(
            'type' => 'Feature',
            'geometry' => array(
                'type' => 'Point',
                'coordinates' => array(
                    floatval($row['longitude']),
                    floatval($row['latitude'])
                )
            ),
            'properties' => array(
                'name' => $row['number'],
                'date' => $row['date'],
                'summary' => 'Test',
                'sighting' => $row['type'],
                'image' => $row['image']
            )

        );
		
		//Combine GeoJSON and row data
        array_push($geojson['features'], $feature);
    }
}

//retrun json encoded result
echo json_encode($geojson);

?>