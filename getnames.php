<?php
require_once('./mysqlaccess.php');

$userIsLoggedIn = $auth->isLoggedIn();

if ($userIsLoggedIn) {
    // user is signed in
    $userID = $auth->getUserId();
    //retrieve all champion records from the UserCollection
    $query = "SELECT * FROM UserCollection WHERE UserID = " . $userID;
    $userCollectionQuery = $mysqli->query($query);
    
    $userChamps = array();
    $userSpells = array();
    $userRelics = array();
    $userEquipment = array();
    while($row = $userCollectionQuery->fetch_assoc()) {
        if($row["Type"] == 1) {
            $userChamps[$row["RuneID"]] = array("RuneID" => $row["RuneID"], "Quantity" => $row["Quantity"], "Level" => $row["Level"]);
        } else if($row["Type"] == 2) {
            $userRelics[$row["RuneID"]] = array("RuneID" => $row["RuneID"], "Quantity" => $row["Quantity"], "Level" => $row["Level"]);
        } else if($row["Type"] == 3) {
            $userSpells[$row["RuneID"]] = array("RuneID" => $row["RuneID"], "Quantity" => $row["Quantity"], "Level" => $row["Level"]);
        } else if($row["Type"] == 4) {
            $userEquipment[$row["RuneID"]] = array("RuneID" => $row["RuneID"], "Quantity" => $row["Quantity"], "Level" => $row["Level"]);
        }
    }
}
else {
    // user is *not* signed in yet
}

function appendQuantity($array, $id) {
    global $userIsLoggedIn;
    if($userIsLoggedIn) {
        return " ● ".$array[$id]["Quantity"]." owned";
    } else {
        return "";
    }
}


$query = "SELECT ID, Name FROM Champions;";
$result = $mysqli->query($query);

$champions = array();

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 1, "SubText"=>"Champion".appendQuantity($userChamps, $row["ID"]), "Explanation"=>"" ) );
}

$query = "SELECT ID, Name FROM Relics;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 2, "SubText"=> "Relic".appendQuantity($userRelics, $row["ID"]), "Explanation"=>"" ) );
}

$query = "SELECT ID, Name FROM Spells;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 3, "SubText"=> "Spell".appendQuantity($userSpells, $row["ID"]), "Explanation"=>"" ) );
}

$query = "SELECT ID, Name FROM Equipment;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["ID"], "Name" =>$row["Name"], "Type"=> 4, "SubText"=> "Equipment".appendQuantity($userEquipment, $row["ID"]), "Explanation"=>"" ) );
}

$query = "SELECT ID, Identifier, Name, Description FROM Conditions;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["Identifier"], "Name" =>$row["Name"], "Type"=> 5, "SubText"=> "Condition", "Explanation"=> $row["Description"] ) );
}

$query = "SELECT ID, Identifier, Name, Description FROM Mechanics;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    array_push($champions, array( "ID"=> $row["Identifier"], "Name" =>$row["Name"], "Type"=> 6, "SubText"=> "Mechanic", "Explanation"=> $row["Description"] ) );
}

$query = "SELECT ID, Name, Description, Level FROM Ability;";
$result = $mysqli->query($query);

while($row = $result->fetch_assoc()) {
    $name = $row["Name"];
    if($row["Level"] != 0) {
        $name = $name . " " .$row["Level"];
    }
    array_push($champions, array( "ID"=> $row["ID"], "Name" => $name, "Type"=> 7, "SubText"=> "Ability", "Explanation"=> $row["Description"] ) );
}

echo json_encode($champions);