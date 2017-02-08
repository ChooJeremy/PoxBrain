<?php
require_once('./mysqlaccess.php');

$query = "SELECT ID, Name FROM Champions;";
$result = $mysqli->query($query);

$champions = array();

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 1, "SubText"=>"Champion", "Explanation"=>"" ) );
}

$query = "SELECT ID, Name FROM Relics;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 2, "SubText"=> "Relic", "Explanation"=>"" ) );
}

$query = "SELECT ID, Name FROM Spells;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 3, "SubText"=> "Spell", "Explanation"=>"" ) );
}

$query = "SELECT ID, Name FROM Equipment;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 4, "SubText"=> "Equipment", "Explanation"=>"" ) );
}

$query = "SELECT ID, Name, Description FROM Conditions;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 5, "SubText"=> "Condition", "Explanation"=> $row["Description"] ) );
}

$query = "SELECT ID, Name, Description FROM Mechanics;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 6, "SubText"=> "Mechanic", "Explanation"=> $row["Description"] ) );
}

$query = "SELECT ID, Name, ShortDescription, Level FROM Ability;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    $name = $row["Name"];
    if($row["Level"] != 0) {
        $name = $name . " " .$row["Level"];
    }
    array_push($champions, array( "ID"=> $row["ID"], "Name" => $name, "Type"=> 7, "SubText"=> "Ability", "Explanation"=> $row["ShortDescription"] ) );
}

echo json_encode($champions);