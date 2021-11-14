<?php
//Database Information
$servername  = "localhost";
$username    = "root";
$password    = "";
$db_name     = "nearest_blood_donor";

// Database Conection
$conn        = new mysqli($servername, $username, $password,$db_name);

if ( $conn->connect_error ) {
  die( "Connection failed: " . $conn->connect_error );
}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nearest Blood Donor</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/fontawesome/css/fontawesome-all.min.css" />
	<link rel="stylesheet" href="assets/style.css" />
  </head>
  <body>
    <div class="container">