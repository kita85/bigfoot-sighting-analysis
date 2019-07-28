<?php

function db() {
	$host="localhost";
	$user="root";
	$password="";
	$dbname="bigfoot";

	//define connection string
	$conn = mysqli_connect($host, $user, $password, $dbname)
	or die ('Could not connect to the database server' . mysqli_connect_error());
	
	return $conn;
}
?>