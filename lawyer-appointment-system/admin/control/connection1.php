<?php
/* error_reporting(E_ALL); */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kortex_lite";

	$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		/* echo "successfull"; */
			/* $conn->close(); */

?>