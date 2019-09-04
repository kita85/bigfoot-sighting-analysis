<?php

//define server variables
include 'conn.php';

			//Connect to database
			$conn = db();
				$sql = "SELECT * from data";
				
				$result = $conn->query($sql);
				$numrows = $result->num_rows;
				$i=1;
				if($result->num_rows > 0) {
					
					$geojson = array(
					   'type'      => 'FeatureCollection',
					   'features'  => array()
					);
					
					while($row = $result->fetch_assoc()) {
						if (is_numeric($row['latitude']) && $numrows !== $i || is_numeric($row['longitude']) && $numrows !== $i) {
							$properties = $row;
							# Remove x and y fields from properties (optional)
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
									'image' => $row['image'],
								),
								//'properties' => $properties
							);
							# Add feature arrays to feature collection array
							array_push($geojson['features'], $feature);
						}
					}

					//header('Content-type: application/json');
					//print_r($geojson);
					echo json_encode($geojson);
				}
				$conn->close();
?>


<?php
/*
//define server variables
include 'conn.php';

			//Connect to database
			$conn = db();
				$sql = "SELECT * from data";
				
				$result = $conn->query($sql);
				$numrows = $result->num_rows;
				$i=1;
				if($result->num_rows > 0) {
					echo '{  "type": "FeatureCollection","features": [';
					while($row = $result->fetch_assoc()) {
						$i++;
						if (is_numeric($row['latitude']) && $numrows !== $i || is_numeric($row['longitude']) && $numrows !== $i) {
							echo '
							{
							 "type": "Feature",
							 "geometry": {
							 "type": "Point",
							 "coordinates": ['.$row['longitude'].', '.$row['latitude'].']
							 },
							 "properties": {
							 "name": "'.$row['number'].'",
							 "date": "'.$row['date'].'",
							 "summary": "'.$row['summary'].'",
							 "sighting": "'.$row['type'].'"
							 }
							}';
						} else {
							echo '
							{
							 "type": "Feature",
							 "geometry": {
							 "type": "Point",
							 "coordinates": ['.$row['longitude'].', '.$row['latitude'].']
							 },
							 "properties": {
							 "name": "'.$row['number'].'",
							 "date": "'.$row['date'].'",
							 "summary": "'.$row['summary'].'",
							 "sighting": "'.$row['type'].'"
							 }
							},';
						}

					}
					echo ']}';
					echo json_encode($json);
				}
				$conn->close();
				
				*/
?>