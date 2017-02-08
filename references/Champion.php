<?php
require_once('mysqlaccess.php');
$allChampions = null;
$allRelics = null;
$allSpells = null;
$allEquipment = null;
$allConditions = null;
$allMechanics = null;
$allAbilities = null;

function getData(&$itemData) {
    global $allChampions, $allRelics, $allSpells, $allEquipment, $allConditions, $allMechanics, $allAbilities;
    for ($i = 0; $i < count($itemData); $i++) {
        $anItem = $itemData[$i];
        if($anItem["Type"] == 1) { //Champion
            $itemData[$i] = array_replace($anItem, $allChampions[$anItem["ID"]]);
        } else if ($anItem["Type"] == 2) { //Relic
            $itemData[$i] = array_replace($anItem, $allRelics[$anItem["ID"]]);
        } else if($anItem["Type"] == 3) { //Spell
            $itemData[$i] = array_replace($anItem, $allSpells[$anItem["ID"]]);
        } else if($anItem["Type"] == 4) { //Equipment
            $itemData[$i] = array_replace($anItem, $allEquipment[$anItem["ID"]]);
        } else if($anItem["Type"] == 5) { //Condition
            $itemData[$i] = array_replace($anItem, $allConditions[$anItem["ID"]]);
        } else if($anItem["Type"] == 6) { //Mechanic
            $itemData[$i] = array_replace($anItem, $allMechanics[$anItem["ID"]]);
        } else if($anItem["Type"] == 7) { //Ability
            $itemData[$i] = array_replace($anItem, $allAbilities[$anItem["ID"]]);
        }
    }
    return $itemData;
}
function preinit($mysqli, $champs, $relics, $spells, $equipment, $condition, $mechanic, $ability) {
    global $allChampions, $allRelics, $allSpells, $allEquipment, $allAbilities, $allMechanics, $allConditions;
    if($ability || $champs) {
        //Read all the abilities
        $allAbilities = array();
        $query = "SELECT * FROM Ability";
        $result = $mysqli->query($query);
        
        while($row = $result->fetch_assoc()) {
            $allAbilities[$row["ID"]] = $row;
            if($row["Level"] != 0) {
                $allAbilities[$row["ID"]]["Name"] = $row["Name"]." ".$row["Level"];
            }
        }
    }
    if($champs) {
        $allChampions = array();
        $query = "SELECT Champions.*, GROUP_CONCAT(DISTINCT Factions.Faction SEPARATOR ' ') as Faction, " .
                "GROUP_CONCAT(DISTINCT Races.Race SEPARATOR ' ') AS Race, " .
                "GROUP_CONCAT(DISTINCT Classes.Class SEPARATOR ' ') AS Class " .
                "FROM Champions INNER JOIN ChampFaction ON Champions.ID = ChampFaction.ChampID " .
                "INNER JOIN Factions ON Factions.ID = ChampFaction.FactionID " .
                "INNER JOIN ChampClass ON ChampClass.ChampID = Champions.ID " .
                "INNER JOIN Classes ON ChampClass.ClassID = Classes.ID " .
                "INNER JOIN ChampRace ON ChampRace.ChampID = Champions.ID " .
                "INNER JOIN Races ON ChampRace.RaceID = Races.ID " .
                "GROUP BY Champions.ID;";
        $result = $mysqli->query($query);
        
        while($row = $result->fetch_assoc()) {
            $allChampions[$row["ID"]] = $row;
        }

        //Read all the links
        $champAbility = array();
        $query = "SELECT * FROM ChampAbility";
        $result = $mysqli->query($query);
        
        while($row = $result->fetch_assoc()) {
            if(!isset($allChampions[$row["ChampID"]]["StartingAbilities"])) {
                $allChampions[$row["ChampID"]]["StartingAbilities"] = [];
                array_push($allChampions[$row["ChampID"]]["StartingAbilities"], $allAbilities[$row["AbilityID"]]);
            } else {
                array_push($allChampions[$row["ChampID"]]["StartingAbilities"], $allAbilities[$row["AbilityID"]]);
            }
        }
        //Read all the upgrades
        $abilitySet = array();
        $query = "SELECT * FROM AbilitySet";
        $result = $mysqli->query($query);
        
        while($row = $result->fetch_assoc()) {
            if(!isset($allChampions[$row["ChampID"]]["AbilitySet"])) {
                $allChampions[$row["ChampID"]]["AbilitySet"] = array();
                $allChampions[$row["ChampID"]]["AbilitySet"][1] = [];
                $allChampions[$row["ChampID"]]["AbilitySet"][2] = [];
            }
            array_push($allChampions[$row["ChampID"]]["AbilitySet"][$row["SetNumber"]], 
                array_replace($allAbilities[$row["AbilityID"]], array("Default" => $row["DefaultAbility"])));
        }
    }
    if($relics) {
        $allRelics = array();
        $query = "SELECT Relics.*, GROUP_CONCAT(Factions.Faction SEPARATOR ' ') as Faction FROM Relics INNER JOIN RelicFaction ON Relics.ID = RelicFaction.RelicID INNER JOIN Factions ON Factions.ID = RelicFaction.FactionID GROUP BY Relics.ID;";
        $result = $mysqli->query($query);
        
        while($row = $result->fetch_assoc()) {
            $allRelics[$row["ID"]] = $row;
        }
    }
    if($spells) {
        $allSpells = array();
        $query = "SELECT Spells.*, GROUP_CONCAT(Factions.Faction SEPARATOR ' ') as Faction FROM Spells INNER JOIN SpellFaction ON Spells.ID = SpellFaction.SpellID INNER JOIN Factions ON Factions.ID = SpellFaction.FactionID GROUP BY Spells.ID;";
        $result = $mysqli->query($query); 
        
        while($row = $result->fetch_assoc()) {
            $allSpells[$row["ID"]] = $row;
        }
    }
    if($equipment) {
        $allEquipment = array();
        $query = "SELECT Equipment.*, GROUP_CONCAT(Factions.Faction SEPARATOR ' ') as Faction FROM Equipment INNER JOIN EquipmentFaction ON Equipment.ID = EquipmentFaction.EquipmentID INNER JOIN Factions ON Factions.ID = EquipmentFaction.FactionID GROUP BY Equipment.ID;";
        $result = $mysqli->query($query);
        
        while($row = $result->fetch_assoc()) {
            $allEquipment[$row["ID"]] = $row;
        }
    }
    if($mechanic) {
        //Read all the mechanics
        $allMechanics = array();
        $query = "SELECT * FROM Mechanics";
        $result = $mysqli->query($query);
        
        while($row = $result->fetch_assoc()) {
            $allMechanics[$row["ID"]] = $row;
        }
    }
    if($condition) {
        //Read all the conditions
        $allConditions = array();
        $query = "SELECT * FROM Conditions";
        $result = $mysqli->query($query);
        
        while($row = $result->fetch_assoc()) {
            $allConditions[$row["ID"]] = $row;
        }
    }
}
?>