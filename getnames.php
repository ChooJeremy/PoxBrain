<?php

//Connect to the database
$host = "127.0.0.1";
$user = "choojeremy";
$pass = "";
$db = "c9";
$port = 3306;
$mysqli = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());

$query = "SELECT ID, Name FROM Champions;";
$result = $mysqli->query($query);

$champions = array();

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 1 ) );
}

$query = "SELECT ID, Name FROM Relics;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 2 ) );
}

$query = "SELECT ID, Name FROM Spells;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 3 ) );
}

$query = "SELECT ID, Name FROM Equipment;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 4 ) );
}

$query = "SELECT ID, Name FROM Conditions;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 5 ) );
}

$query = "SELECT ID, Name FROM Mechanics;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 6 ) );
}

$query = "SELECT ID, Name FROM Ability;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 7 ) );
}

echo json_encode($champions);