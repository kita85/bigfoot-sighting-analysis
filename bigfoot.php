<?php

//define server variables
include 'inc/conn.php';

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
    $conn = db();
    
    //Reusable database query for all charts and tables.
    $sql    = "SELECT `" . $searchValue . "`, COUNT(`" . $searchValue . "`) AS `count` FROM `data` WHERE `" . $searchValue . "`!='' GROUP BY `" . $searchValue . "` ORDER BY `" . $orderValue . "` " . $dirValue . " LIMIT " . $limitValue . ";";
    $result = $conn->query($sql);
    
    //Fetch results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //Return results as json string
            echo json_encode($row[$searchValue]) . ",";
            echo json_encode($row['count']) . ",";
        }
    }
    $conn->close();
}
?>
