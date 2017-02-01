<?php
require_once('./mysqlaccess.php');

$query = "SELECT LastUpdateID FROM PoxDB;";
$result = $mysqli->query($query);

$lastUpdateID = 0;

while($row = $result->fetch_assoc()) {
    $lastUpdateID = $row["LastUpdateID"];
}

echo $lastUpdateID;