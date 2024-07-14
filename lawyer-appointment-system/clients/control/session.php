<?php
session_start();

	
?>

<?php

	$_SESSION['username']= "aparna@gmail.com";
	$_SESSION['password']= "aparna";
	header("location:client_data.php");
	echo "session variables are set";
?>  