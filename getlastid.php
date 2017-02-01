<?php

//Connect to the database
$host = "127.0.0.1";
$user = "choojeremy";
$pass = "";
$db = "c9";
$port = 3306;
$mysqli = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());

$query = "SELECT LastUpdateID FROM PoxDB;";
$result = $mysqli->query($query);

$lastUpdateID = 0;

while($row = $result->fetch_assoc()) {
    $lastUpdateID = $row["LastUpdateID"];
}

echo $lastUpdateID;