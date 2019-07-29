<?php

function db() {
	$host="mysql";
	$user="root";
	$password="P@55w0rd";
	$dbname="bigfoot";

	//define connection string
	$conn = mysqli_connect($host, $user, $password, $dbname)
	or die ('Could not connect to the database server' . mysqli_connect_error());
	
	return $conn;
}
?>
