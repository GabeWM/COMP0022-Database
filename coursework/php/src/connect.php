<?php

$host = "db";
$user = "root";
$pass = "password";
$mydatabase = "comp0022_database";


// Create connection
$connection = mysqli_connect($host, $user, $pass, $mydatabase);

// Check connection
if ($connection->connect_error) {
    // connection failed 
  die("Connection failed: " . $connection->connect_error);

}
?>
