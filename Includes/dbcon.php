<?php
	$host = "localhost:3306";
	$user = "root";
	$pass = "Vaidehi@28";
	$db = "attendancefinal";
	
	$conn = new mysqli($host, $user, $pass, $db);
	if($conn->connect_error){
		echo "Seems like you have not configured the database. Failed To Connect to database:" . $conn->connect_error;
	}
?>