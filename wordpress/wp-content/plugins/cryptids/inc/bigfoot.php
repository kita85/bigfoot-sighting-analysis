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


//Call the function if the ajax post is not empty.
if (!empty($_POST)) {
    //Add sanitization in case Sneaky Pete tries to ruin my day.
    $searchValue = filter_var($_POST['searchValue'], FILTER_SANITIZE_STRING); //Row to be queried 
    $orderValue  = filter_var($_POST['orderValue'], FILTER_SANITIZE_STRING); //Which variable to order data by
    $dirValue    = filter_var($_POST['dirValue'], FILTER_SANITIZE_STRING); //ASC or DESC order by direction
    $limitValue  = filter_var($_POST['limitValue'], FILTER_VALIDATE_INT); //Limit results
    charts($searchValue, $orderValue, $dirValue, $limitValue);
}


function charts($searchValue, $orderValue, $dirValue, $limitValue)
{
    
    //Connect to the database
    global $wpdb;
    $table_name = $wpdb->prefix . 'bigfoot';
    
    $result = $wpdb->get_results("SELECT `" . $searchValue . "`, COUNT(`" . $searchValue . "`) AS `count` FROM " . $table_name . " WHERE `" . $searchValue . "`!='' GROUP BY `" . $searchValue . "` ORDER BY `" . $orderValue . "` " . $dirValue . " LIMIT " . $limitValue . ";", ARRAY_A);
    
    //retrun json encoded result
    foreach ($result as $row) {
        echo json_encode($row[$searchValue]) . ",";
        echo json_encode($row['count']) . ",";
    }
    
}
?>