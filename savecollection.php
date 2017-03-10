<?php
    require_once('./mysqlaccess.php');
    
    if (!$auth->isLoggedIn()) {
        // user is not signed in
        echo "Not Logged in";
    }
    else {
        $userID = $auth->getUserId();
        
        $theCollection = json_decode($_POST["collection_text"]);
        if($theCollection === NULL || !isset($theCollection->balance, $theCollection->champions, $theCollection->spells, $theCollection->relics, $theCollection->equipment)) {
            echo "Error parsing text. Make sure you copied everything that was there (press Ctrl + A to ensure that you selected everything). ";
            echo "Also ensure that you are actually logged in. You should be receiving a white screen with text that starts with {\"balance\": <br />";
            echo "Additionally, make sure that the only text in the box is that long text from poxnora. There should be no additional characters which may be accidentally typed.<br />";
            die();
        }
        
        $shards = $theCollection->balance;
        //Update shards on the user's accounts
        if (!($shardUpdate = $mysqli->prepare("UPDATE UserData SET Shards = ? WHERE UserID = ?"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
        }
        
        if (!$shardUpdate->bind_param("ii", $shards, $userID)) {
            echo "Binding parameters failed: (" . $shardUpdate->errno . ") " . $shardUpdate->error; die();
        }
        
        if (!$shardUpdate->execute()) {
            echo "Execute failed: (" . $shardUpdate->errno . ") " . $shardUpdate->error;  die();
        }
        $shardUpdate->close();
        
        //First make sure all of the user's records is gone.
        if (!($recordDelete = $mysqli->prepare("DELETE FROM UserCollection WHERE UserID = ?"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
        }
        
        if (!$recordDelete->bind_param("i", $userID)) {
            echo "Binding parameters failed: (" . $recordDelete->errno . ") " . $recordDelete->error; die();
        }
        
        if (!$recordDelete->execute()) {
            echo "Execute failed: (" . $recordDelete->errno . ") " . $recordDelete->error;  die();
        }
        $recordDelete->close();
        
        $type = 1;
        foreach($theCollection->champions as $aChamp) {
            if (!($championAdd = $mysqli->prepare("INSERT INTO UserCollection VALUES(?, ?, ?, ?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$championAdd->bind_param("iiiii", $userID, $aChamp->baseId, $type, $aChamp->count, $aChamp->id)) {
                echo "Binding parameters failed: (" . $championAdd->errno . ") " . $championAdd->error; die();
            }
            
            if (!$championAdd->execute()) {
                echo "Execute failed: (" . $championAdd->errno . ") " . $championAdd->error;  die();
            }
            $championAdd->close();
        }
        
        //spells
        $type = 3;
        foreach($theCollection->spells as $aSpell) {
            if (!($spellAdd = $mysqli->prepare("INSERT INTO UserCollection VALUES(?, ?, ?, ?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$spellAdd->bind_param("iiiii", $userID, $aSpell->baseId, $type, $aSpell->count, $aSpell->id)) {
                echo "Binding parameters failed: (" . $spellAdd->errno . ") " . $spellAdd->error; die();
            }
            
            if (!$spellAdd->execute()) {
                echo "Execute failed: (" . $spellAdd->errno . ") " . $spellAdd->error;  die();
            }
            $spellAdd->close();
        }
        
        //Relics
        $type = 2;
        foreach($theCollection->relics as $aRelic) {
            if (!($relicAdd = $mysqli->prepare("INSERT INTO UserCollection VALUES(?, ?, ?, ?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$relicAdd->bind_param("iiiii", $userID, $aRelic->baseId, $type, $aRelic->count, $aRelic->id)) {
                echo "Binding parameters failed: (" . $relicAdd->errno . ") " . $relicAdd->error; die();
            }
            
            if (!$relicAdd->execute()) {
                echo "Execute failed: (" . $relicAdd->errno . ") " . $relicAdd->error;  die();
            }
            $relicAdd->close();
        }
        
        //equipment
        $type = 4;
        foreach($theCollection->equipment as $aEquipment) {
            if (!($equipmentAdd = $mysqli->prepare("INSERT INTO UserCollection VALUES(?, ?, ?, ?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$equipmentAdd->bind_param("iiiii", $userID, $aEquipment->baseId, $type, $aEquipment->count, $aEquipment->id)) {
                echo "Binding parameters failed: (" . $equipmentAdd->errno . ") " . $equipmentAdd->error; die();
            }
            
            if (!$equipmentAdd->execute()) {
                echo "Execute failed: (" . $equipmentAdd->errno . ") " . $equipmentAdd->error;  die();
            }
            $equipmentAdd->close();
        }
        
        echo "OK";
    }