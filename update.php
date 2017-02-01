<?php
function handleAbility($mysqli, &$abilityNames, $theAbility) {
   if(!in_array($theAbility->id, $abilityNames)) {
        array_push($abilityNames, $theAbility->id);
        if (!($abilityAdd = $mysqli->prepare("INSERT INTO Ability VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
        }
        
        if (!$abilityAdd->bind_param("iissiiiis", $theAbility->id, $theAbility->apCost, $theAbility->name, $theAbility->shortDescription, 
                $theAbility->activationType, $theAbility->level, $theAbility->cooldown, $theAbility->noraCost, $theAbility->iconName)) {
            echo "Binding parameters failed: (" . $abilityAdd->errno . ") " . $abilityAdd->error; die();
        }
        
        if (!$abilityAdd->execute()) {
            echo "Execute failed: (" . $abilityAdd->errno . ") " . $abilityAdd->error;  die();
        }
        $abilityAdd->close();
    }
}
header("Content-Type: text/plain");
//Connect to the database
$host = "127.0.0.1";
$user = "choojeremy";
$pass = "";
$db = "c9";
$port = 3306;
$mysqli = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());

echo "Preparing update... \n";

echo "Deleting all current records... \n";

mysqli_query($mysqli, "DELETE FROM Conditions");
mysqli_query($mysqli, "DELETE FROM Mechanics");
mysqli_query($mysqli, "DELETE FROM Champions");
mysqli_query($mysqli, "DELETE FROM Classes");
mysqli_query($mysqli, "DELETE FROM Races");
mysqli_query($mysqli, "DELETE FROM Ability");
mysqli_query($mysqli, "DELETE FROM ChampClass");
mysqli_query($mysqli, "DELETE FROM ChampRace");
mysqli_query($mysqli, "DELETE FROM ChampFaction");
mysqli_query($mysqli, "DELETE FROM ChampAbility");
mysqli_query($mysqli, "DELETE FROM AbilitySet");
mysqli_query($mysqli, "DELETE FROM Spells");
mysqli_query($mysqli, "DELETE FROM SpellFaction");
mysqli_query($mysqli, "DELETE FROM Relics");
mysqli_query($mysqli, "DELETE FROM RelicFaction");
mysqli_query($mysqli, "DELETE FROM Equipment");
mysqli_query($mysqli, "DELETE FROM EquipmentFaction");

echo "Preparing to add new records. Reading: conditions... \n";

//conditions
$ch = curl_init("https://poxdb-choojeremy.c9users.io/api/conditions.json"); // such as http://example.com/example.xml
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);

$conditions = json_decode($data)->conditions;
$idCounter = 1;
foreach ($conditions as $aCondition) {
    if (!($conditionAdd = $mysqli->prepare("INSERT INTO Conditions VALUES(?, ?, ?, ?)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
    }
    
    if (!$conditionAdd->bind_param("isss", $idCounter, $aCondition->name, $aCondition->key, $aCondition->description)) {
        echo "Binding parameters failed: (" . $conditionAdd->errno . ") " . $conditionAdd->error; die();
    }
    
    if (!$conditionAdd->execute()) {
        echo "Execute failed: (" . $conditionAdd->errno . ") " . $conditionAdd->error;  die();
    }
    $conditionAdd->close();
    
    $idCounter = $idCounter + 1;
}

echo "Preparing to add new records. Reading: mechanics... \n";

$ch = curl_init("https://poxdb-choojeremy.c9users.io/api/mechanics.json"); // such as http://example.com/example.xml
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);

$mechanics = json_decode($data)->mechanics;
$idCounter = 1;
foreach ($mechanics as $aMechanic) {
    if (!($mechanicAdd = $mysqli->prepare("INSERT INTO Mechanics VALUES(?, ?, ?, ?)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
    }
    
    if (!$mechanicAdd->bind_param("isss", $idCounter, $aMechanic->name, $aMechanic->key, $aMechanic->description)) {
        echo "Binding parameters failed: (" . $mechanicAdd->errno . ") " . $mechanicAdd->error; die();
    }
    
    if (!$mechanicAdd->execute()) {
        echo "Execute failed: (" . $mechanicAdd->errno . ") " . $mechanicAdd->error;  die();
    }
    $mechanicAdd->close();
    
    $idCounter = $idCounter + 1;
}

echo "Preparing to add new records. Reading: champions, relics, spells and equipment... \n";
echo "Receiving the information from server...";
$ch = curl_init("https://poxdb-choojeremy.c9users.io/api/main.json"); // such as http://example.com/example.xml
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);
curl_close($ch);

$classNames = [];
$raceNames = [];
$factionNames = ["Forglar Swamp", "Forsaken Wastes", "Ironfist Stronghold", "K'thir Forest", "Savage Tundra", "Shattered Peaks", "Sundered Lands", "Underdepths"];
$abilityNames = [];
$champCounter = 0;

$allData = json_decode($data);
$champions = $allData->champs;
$totalChamps = count($champions);
foreach ($champions as $aChampion) {
    if (!($championAdd = $mysqli->prepare("INSERT INTO Champions VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
    }
    
    if (!$championAdd->bind_param("issiiiiiississsiiii", $aChampion->id, $aChampion->name, $aChampion->description, $aChampion->maxRng, $aChampion->minRng,
                            $aChampion->defense, $aChampion->speed, $aChampion->damage, $aChampion->hitPoints, $aChampion->size, $aChampion->rarity,
                            $aChampion->noraCost, $aChampion->hash, $aChampion->artist, $aChampion->runeSet, $aChampion->forSale, $aChampion->tradeable,
                            $aChampion->allowRanked, $aChampion->deckLimit)) {
        echo "Binding parameters failed: (" . $championAdd->errno . ") " . $championAdd->error; die();
    }
    
    if (!$championAdd->execute()) {
        echo "Execute failed: (" . $championAdd->errno . ") " . $championAdd->error;  die();
    }
    $championAdd->close();

    echo "\r".$champCounter ."/".$totalChamps." complete. ";
    
    //Handle classes 
    foreach($aChampion->classes as $aClass) {
        $position = array_search($aClass, $classNames);
        if($position === false) {
            array_push($classNames, $aClass);
            $position = count($classNames);
            if (!($classAdd = $mysqli->prepare("INSERT INTO Classes VALUES(?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$classAdd->bind_param("is", count($classNames), $aClass)) {
                echo "Binding parameters failed: (" . $classAdd->errno . ") " . $classAdd->error; die();
            }
            
            if (!$classAdd->execute()) {
                echo "Execute failed: (" . $classAdd->errno . ") " . $classAdd->error;  die();
            }
            $classAdd->close();
        } else {
            $position = $position + 1; //array seearch is 0 index but the ids of the classes are indexed starting from 1.
        }
        
        if (!($classAdd = $mysqli->prepare("INSERT INTO ChampClass VALUES(?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
        }
        
        if (!$classAdd->bind_param("ii", $aChampion->id, $position)) {
            echo "Binding parameters failed: (" . $classAdd->errno . ") " . $classAdd->error; die();
        }
        
        if (!$classAdd->execute()) {
            echo "Execute failed: (" . $classAdd->errno . ") " . $classAdd->error;  die();
        }
        $classAdd->close();
    }
    
    echo "Class... ";

    //Handle races
    foreach($aChampion->races as $aRace) {
        $position = array_search($aRace, $raceNames);
        if($position === false) {
            array_push($raceNames, $aRace);
            $position = count($raceNames);
            if (!($raceAdd = $mysqli->prepare("INSERT INTO Races VALUES(?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$raceAdd->bind_param("is", count($raceNames), $aRace)) {
                echo "Binding parameters failed: (" . $raceAdd->errno . ") " . $raceAdd->error; die();
            }
            
            if (!$raceAdd->execute()) {
                echo "Execute failed: (" . $raceAdd->errno . ") " . $raceAdd->error;  die();
            }
            $raceAdd->close();
        } else {
            $position = $position + 1; //array seearch is 0 index but the ids of the classes are indexed starting from 1.
        }
        
        if (!($raceAdd = $mysqli->prepare("INSERT INTO ChampRace VALUES(?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
        }
        
        if (!$raceAdd->bind_param("ii", $aChampion->id, $position)) {
            echo "Binding parameters failed: (" . $raceAdd->errno . ") " . $raceAdd->error; die();
        }
        
        if (!$raceAdd->execute()) {
            echo "Execute failed: (" . $raceAdd->errno . ") " . $raceAdd->error;  die();
        }
        $raceAdd->close();
    }
        
    echo "Race... ";
    
    //Handle factions
    $factionsAdded = [];
    foreach($aChampion->factions as $aFaction) {
        $position = array_search($aFaction, $factionNames);
        if($position === false) {
            array_push($factionNames, $aFaction);
            $position = count($factionNames);
            if (!($factionAdd = $mysqli->prepare("INSERT INTO Factions VALUES(?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$factionAdd->bind_param("is", count($factionNames), $aFaction)) {
                echo "Binding parameters failed: (" . $factionAdd->errno . ") " . $factionAdd->error; die();
            }
            
            if (!$factionAdd->execute()) {
                echo "Execute failed: (" . $factionAdd->errno . ") " . $factionAdd->error;  die();
            }
            $factionAdd->close();
        } else {
            $position = $position + 1;
        }
        
        //Champ 920 has underdepths listed twice under the factions list.
        if(!in_array($aFaction, $factionsAdded)) {
            array_push($factionsAdded, $aFaction);
            
            if (!($factionAdd = $mysqli->prepare("INSERT INTO ChampFaction VALUES(?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$factionAdd->bind_param("ii", $aChampion->id, $position)) {
                echo "Binding parameters failed: (" . $factionAdd->errno . ") " . $factionAdd->error; die();
            }
            
            if (!$factionAdd->execute()) {
                echo "Execute failed: (" . $factionAdd->errno . ") " . $factionAdd->error;  die();
            }
            $factionAdd->close();
        }
    }
    
    echo "Faction... ";
    
    if(isset($aChampion->startingAbilities)) {
        //Handle abilities, and also for the level up ones
        foreach($aChampion->startingAbilities as $anAbility) {
            handleAbility($mysqli, $abilityNames, $anAbility);
            
            if (!($abilityAdd = $mysqli->prepare("INSERT INTO ChampAbility VALUES(?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$abilityAdd->bind_param("ii", $aChampion->id, $anAbility->id)) {
                echo "Binding parameters failed: (" . $abilityAdd->errno . ") " . $abilityAdd->error; die();
            }
            
            if (!$abilityAdd->execute()) {
                echo "Execute failed: (" . $abilityAdd->errno . ") " . $abilityAdd->error;  die();
            }
            $abilityAdd->close();
        }
        
        echo "Starting abilities... ";
    }
    
    if(isset($aChampion->abilitySets)) {
        $count = 1;
        foreach($aChampion->abilitySets as $anAbilitySet) {
            foreach ($anAbilitySet->abilities as $anAbility) {
                handleAbility($mysqli, $abilityNames, $anAbility);
                
                if (!($abilityAdd = $mysqli->prepare("INSERT INTO AbilitySet VALUES(?, ?, ?, ?)"))) {
                    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
                }
                
                if (!$abilityAdd->bind_param("iiii", $aChampion->id, $count, $anAbility->default, $anAbility->id)) {
                    echo "Binding parameters failed: (" . $abilityAdd->errno . ") " . $abilityAdd->error; die();
                }
                
                if (!$abilityAdd->execute()) {
                    echo "Execute failed: (" . $abilityAdd->errno . ") " . $abilityAdd->error;  die();
                }
                $abilityAdd->close();
                
            }
            $count = $count + 1;
        }
        
        echo "Upgrades... ";
        
        $champCounter = $champCounter + 1;
    }
}

echo "\rChampions complete. Preparing for adding relics...                                             \n";

$totalRelics = count($allData->relics);
$relicCounter = 0;
foreach ($allData->relics as $aRelic) {
    if (!($relicAdd = $mysqli->prepare("INSERT INTO Relics VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
    }
    
    if (!$relicAdd->bind_param("isssisssiiiiissi", $aRelic->id, $aRelic->name, $aRelic->description, $aRelic->flavorText,
                            $aRelic->noraCost, $aRelic->artist, $aRelic->rarity, $aRelic->runeSet, $aRelic->forSale, $aRelic->allowRanked,
                            $aRelic->tradeable, $aRelic->defense, $aRelic->hitPoints, $aRelic->size, $aRelic->hash, $aRelic->deckLimit)) {
        echo "Binding parameters failed: (" . $relicAdd->errno . ") " . $relicAdd->error; die();
    }
    
    if (!$relicAdd->execute()) {
        echo "Execute failed: (" . $relicAdd->errno . ") " . $relicAdd->error;  die();
    }
    $relicAdd->close();
    
    //Handle factions
    $factionsAdded = [];
    foreach($aRelic->factions as $aFaction) {
        $position = array_search($aFaction, $factionNames) + 1;
        
        //Champ 920 has underdepths listed twice under the factions list.
        if(!in_array($aFaction, $factionsAdded)) {
            array_push($factionsAdded, $aFaction);
            
            if (!($factionAdd = $mysqli->prepare("INSERT INTO RelicFaction VALUES(?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$factionAdd->bind_param("ii", $aRelic->id, $position)) {
                echo "Binding parameters failed: (" . $factionAdd->errno . ") " . $factionAdd->error; die();
            }
            
            if (!$factionAdd->execute()) {
                echo "Execute failed: (" . $factionAdd->errno . ") " . $factionAdd->error;  die();
            }
            $factionAdd->close();
        }
    }


    $relicCounter = $relicCounter + 1;
    echo "\r".$relicCounter ."/".$totalRelics." complete. ";
}

echo "\rRelics complete. Preparing for adding spells...                                             \n";

$spellCounter = 0;
$totalSpells = count($allData->spells);
foreach($allData->spells as $aSpell) {
    if (!($spellsAdd = $mysqli->prepare("INSERT INTO Spells VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
    }
    
    if (!$spellsAdd->bind_param("isssissisiiisi", $aSpell->id, $aSpell->name, $aSpell->description, $aSpell->flavorText,
                            $aSpell->noraCost, $aSpell->artist, $aSpell->rarity, $aSpell->cooldown, $aSpell->runeSet, $aSpell->forSale, $aSpell->allowRanked,
                            $aSpell->tradeable, $aSpell->hash, $aSpell->deckLimit)) {
        echo "Binding parameters failed: (" . $spellsAdd->errno . ") " . $spellsAdd->error; die();
    }
    
    if (!$spellsAdd->execute()) {
        echo "Execute failed: (" . $spellsAdd->errno . ") " . $spellsAdd->error;  die();
    }
    $spellsAdd->close();
    
    //Handle factions
    $factionsAdded = [];
    foreach($aSpell->factions as $aFaction) {
        $position = array_search($aFaction, $factionNames) + 1;

        //Champ 920 has underdepths listed twice under the factions list.
        if(!in_array($aFaction, $factionsAdded)) {
            array_push($factionsAdded, $aFaction);
            
            if (!($factionAdd = $mysqli->prepare("INSERT INTO SpellFaction VALUES(?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$factionAdd->bind_param("ii", $aSpell->id, $position)) {
                echo "Binding parameters failed: (" . $factionAdd->errno . ") " . $factionAdd->error; die();
            }
            
            if (!$factionAdd->execute()) {
                echo "Execute failed: (" . $factionAdd->errno . ") " . $factionAdd->error;  die();
            }
            $factionAdd->close();
        }
    }

    $spellCounter = $spellCounter + 1;
    echo "\r".$spellCounter ."/". $totalSpells." complete. ";
}

echo "\rSpells complete. Preparing for adding equipments...\n";

$equipmentCounter = 0;
$totalEquipment = count($allData->equips);
foreach($allData->equips as $anEquipment) {
    if (!($equipmentAdd = $mysqli->prepare("INSERT INTO Equipment VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
    }
    
    if (!$equipmentAdd->bind_param("isssisssiiisi", $anEquipment->id, $anEquipment->name, $anEquipment->description, $anEquipment->flavorText,
                            $anEquipment->noraCost, $anEquipment->artist, $anEquipment->rarity, $anEquipment->runeSet, $anEquipment->forSale, $anEquipment->allowRanked,
                            $anEquipment->tradeable, $anEquipment->hash, $anEquipment->deckLimit)) {
        echo "Binding parameters failed: (" . $equipmentAdd->errno . ") " . $equipmentAdd->error; die();
    }
    
    if (!$equipmentAdd->execute()) {
        echo "Execute failed: (" . $equipmentAdd->errno . ") " . $equipmentAdd->error;  die();
    }
    $equipmentAdd->close();
    
    //Handle factions
    $factionsAdded = [];
    foreach($anEquipment->factions as $aFaction) {
        $position = array_search($aFaction, $factionNames) + 1;

        //Champ 920 has underdepths listed twice under the factions list.
        if(!in_array($aFaction, $factionsAdded)) {
            array_push($factionsAdded, $aFaction);
            
            if (!($factionAdd = $mysqli->prepare("INSERT INTO EquipmentFaction VALUES(?, ?)"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
            }
            
            if (!$factionAdd->bind_param("ii", $anEquipment->id, $position)) {
                echo "Binding parameters failed: (" . $factionAdd->errno . ") " . $factionAdd->error; die();
            }
            
            if (!$factionAdd->execute()) {
                echo "Execute failed: (" . $factionAdd->errno . ") " . $factionAdd->error;  die();
            }
            $factionAdd->close();
        }
    }

    $equipmentCounter = $equipmentCounter + 1;
    echo "\r".$equipmentCounter ."/". $totalEquipment." complete. ";
}

echo "\rEquipment complete. Starting database maintenance...                                      \n";

if (!($dbUpdate = $mysqli->prepare("UPDATE PoxDB SET LastUpdateID = LastUpdateID + 1, LastUpdateTime = ?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
}

if (!$dbUpdate->bind_param("s", date('Y-m-d H:i:s'))) {
    echo "Binding parameters failed: (" . $dbUpdate->errno . ") " . $dbUpdate->error; die();
}

if (!$dbUpdate->execute()) {
    echo "Execute failed: (" . $dbUpdate->errno . ") " . $dbUpdate->error;  die();
}
$dbUpdate->close();

echo "Routine maintenance completed. Finishing up...                        \n";

?>