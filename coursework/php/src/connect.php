<?php

$host = "db";
$user = "root";
$pass = "password";
$my_database = "comp0022_database";


// Create connection
$connection = mysqli_connect($host, $user, $pass, $my_database);

// Check connection
if ($connection->connect_error) {
    // connection failed 
  die("Connection failed: " . $connection->connect_error);

}
?>
