<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "evently";

	$shost = "localhost";
	$suser = "sql_evently_work";
	$spass = "44372f11f0a3f8";
	$sdb = "sql_evently_work";
	
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
		$conn = new mysqli($shost, $suser, $spass, $sdb);
		$link .= "/";
	}

	if (!$conn) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	$base_url = $link;
	//echo $base_url;
?>