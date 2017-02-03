<?php 
require_once('./mysqlaccess.php');

//Find everywhere
if (!($dbCheck = $mysqli->prepare("SELECT * FROM " . $table . " WHERE ID = ?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
}

if (!$dbCheck->bind_param("i", $_GET["id"])) {
    echo "Binding parameters failed: (" . $dbCheck->errno . ") " . $dbCheck->error; die();
}

if (!$dbCheck->execute()) {
    echo "Execute failed: (" . $dbCheck->errno . ") " . $dbCheck->error;  die();
}
