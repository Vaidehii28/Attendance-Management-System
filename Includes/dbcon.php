<?php
	$host = "127.0.0.1";
	$user = "root";
	$pass = "";
	$db = "attendancefinal";
	
	$conn = new mysqli($host, $user, $pass, $db);
	if($conn->connect_error){
		echo "Seems like you have not configured the database. Failed To Connect to database:" . $conn->connect_error;
	}
?>