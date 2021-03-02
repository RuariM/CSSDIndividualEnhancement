<?php
	// Database configuration 
	$hostname = "localhost"; 
	$username = "root"; 
	$password = ""; 
	$dbname   = "CSSD"; 
	 
	// Create database connection 
	$db = mysqli_connect($hostname, $username, $password, $dbname); 
	 
	// Check connection
	if(mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}

?>