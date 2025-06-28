<?php
	$servername="localhost";
	$username="root";
	$password="";
	$database="fbs";
//create connection
	$connection=mysqli_connect($servername, $username, $password, $database);
//check connection
	if(!$connection){
		die ("connection fail".mysqli_connect_error());
	}
	echo "Connected successfully.";
?>