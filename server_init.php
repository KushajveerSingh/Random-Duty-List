<?php
$serverName = "localhost";
$userName = "";
$password = "";
$dbName = "";

$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$currentDate = date("Y/m/d");
?>
