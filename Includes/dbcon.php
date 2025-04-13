<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "evently";
	
	/*$conn = new mysqli($host, $user, $pass, $db);
	if($conn->connect_error){
		echo "Seems like you have not configured the database. Failed To Connect to database:" . $conn->connect_error;
	}*/

	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	{
		$link = "https://";
	}
	else
	{ 
		$link = "http://"; 
	}
		
	$link .= $_SERVER['HTTP_HOST'];

	if ($_SERVER['HTTP_HOST'] == "localhost") 
	{
		$link .= "/Evently/";
		$conn = new mysqli($host, $user, $pass, $db);
	}
	else
	{
		$conn = new mysqli($host, $user, $pass, $db);
		$link .= "/";
	}

	if (!$conn) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	$base_url = $link;
	//echo $base_url;
?>