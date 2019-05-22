<?php

//define server variables
include 'conn.php';

//Which function to call
if(!empty($_POST)) {
	$searchValue = $_POST['searchValue'];
	charts($searchValue);
}
		

		function charts ($searchValue) {
				$conn = db();
				//if ($searchValue === "year") {
					//$sql = "SELECT `".$searchValue."`, COUNT(`".$searchValue."`), floor(year/10)*10 as count from `data` group by count;";
					//$sql = "SELECT `".$searchValue."`, COUNT(`".$searchValue."`) AS `count` FROM `data` WHERE `".$searchValue."` IS NOT NULL GROUP BY `".$searchValue."` LIMIT 5;";
				//} else {
					$sql = "SELECT `".$searchValue."`, COUNT(`".$searchValue."`) AS `count` FROM `data` WHERE `".$searchValue."`!='' GROUP BY `".$searchValue."` ORDER BY `count` DESC LIMIT 10;";
				//}
				

				$result = $conn->query($sql);
				
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo json_encode($row[$searchValue]).",";
						echo json_encode($row['count']).",";
					}
				}
				$conn->close();
			}
?>