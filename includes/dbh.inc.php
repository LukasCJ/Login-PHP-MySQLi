<?php

$serverName = "localhost"; //host
$dBUsername = "root"; //default namn för phpmyadmin-användare
$dBPassword = "root"; //default lösenord för phpmyadmin-användare
$dBName = "logsite"; //databas namn i phpmyadmin

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName); //används för att koppla inloggnings- eller signup processen till databasen

if (!$conn) { //om kopplingen misslyckas
    die("Connection failed: " . mysqli_connect_error());
}