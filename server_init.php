<?php
$serverName = "localhost";
$userName = "kushaj";
$password = "John!cena@";
$dbName = "DrinkPolice";

$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
