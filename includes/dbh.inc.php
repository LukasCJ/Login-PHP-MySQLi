<?php

$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "root";
$dBName = "logsite";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) { //if connection fails
    die("Connection failed: " . mysqli_connect_error());
}