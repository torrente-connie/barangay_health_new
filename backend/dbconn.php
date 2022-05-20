<?php

function dbConn(){
	// $servername = "sql305.epizy.com";
	// $username = "epiz_30468562";
	// $password = "fE4Tdprz03go";
	// $db="epiz_30468562_barangayhealth_db";

	$servername = "localhost";
	$username = "root";
	$password = "";
	//$db="mca";
	$db="barangayhealth_db";

	static $conn;
	$conn = mysqli_connect($servername, $username, $password,$db);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	  }
		return $conn;
	}
?>