<?php

//define server variables
include 'conn.php';

//Call the function if the ajax post is not empty. **FIX Sanitation
if (!empty($_POST)) {
    $searchValue = $_POST['searchValue']; //Row to be queried 
	$orderValue = $_POST['orderValue']; //Which variable to order data by
	$dirValue = $_POST['dirValue']; //ASC or DESC order by direction
	$limitValue = $_POST['limitValue']; //Limit results
	charts($searchValue,$orderValue,$dirValue,$limitValue);
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
