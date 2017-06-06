<?php 
require_once('./mysqlaccess.php');
require_once('./references/Champion.php');
$item = array("ID" => $_GET["id"], "Type" => $_GET["type"]);
if($_GET["type"] == 1) {
    preinit($mysqli, true, false, false, false, false, false, false);
} else if($_GET["type"] == 2) {
    preinit($mysqli, false, true, false, false, false, false, false);
} else if($_GET["type"] == 3) {
    preinit($mysqli, false, false, true, false, false, false, false);
} else if($_GET["type"] == 4) {
    preinit($mysqli, false, false, false, true, false, false, false);
} else if($_GET["type"] == 5) {
    preinit($mysqli, false, false, false, false, true, false, false);
} else if($_GET["type"] == 6) {
    preinit($mysqli, false, false, false, false, false, true, false);
} else if($_GET["type"] == 7) {
    preinit($mysqli, false, false, false, false, false, false, true);
} else {
    die("No such type");
}

$items = array();
array_push($items, $item);

getData($items);
$item = $items[0];

//retrieve how many owned copies of that item
if ($auth->isLoggedIn()) {
    // user is signed in
    $userID = $auth->getUserId();
    //retrieve all champion records from the UserCollection
    if (!($dbCheck = $mysqli->prepare("SELECT Quantity FROM UserCollection WHERE UserID = ? AND Type = ? AND RuneID = ?"))) {
        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
    }
    
    if (!$dbCheck->bind_param("iii", $userID, $item["Type"], $item["ID"])) {
        echo "Binding parameters failed: (" . $dbCheck->errno . ") " . $dbCheck->error; die();
    }
    
    if (!$dbCheck->execute()) {
        echo "Execute failed: (" . $dbCheck->errno . ") " . $dbCheck->error;  die();
    }
    
    $dbCheck->bind_result($quantity);
    
    /* fetch values */
    //Add relevancy
    while ($dbCheck->fetch()) {
        $item["Quantity"] = $quantity;
    }
    
    $dbCheck->close();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title><?php echo $item["Name"] ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">
    <link href="css/rune.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
  </head>

  <body>
    
    <?php require_once('./header.php'); ?>
    <!--<div class="factions">
      <div class="container">
        <div class="col-md-6">
            <div id="f-s" class="col-md-3">
                Forglar Swamp
            </div>
            <div id="f-w" class="col-md-3">
                Forsaken Wastes
            </div>
            <div id="i-s" class="col-md-3">
                Ironfist Stronghold
            </div>
            <div id="k-f" class="col-md-3">
                K'thir Forest
            </div>
        </div>
        <div class="col-md-6">
            <div id="s-t" class="col-md-3">
                Savage Tundra
            </div>
            <div id="s-p" class="col-md-3">
                Shattered Peaks
            </div>
            <div id="s-l" class="col-md-3">
                Sundered Lands
            </div>
            <div id="u-d" class="col-md-3">
                Underdepths
            </div>
        </div>
      </div>
    </div>-->
    
    <div id="main-info" class="container">
        <div class="row">
            <div id="main-info" class="info-group col-sm-6">
                <div class="card">
                  <h1 class="card-header">
                      <?php if($item["Type"] >= 1 && $item["Type"] <= 4) { ?>
                          <img class="img-small" src="https://d2aao99y1mip6n.cloudfront.net/images/runes/sm/<?php echo $item['Hash']; ?>.png" />
                      <?php } ?>
                      <?php echo $item["Name"]; ?>
                  </h1>
                  <div class="card-block">
                      <?php 
                      if($item["Type"] >= 1 && $item["Type"] <= 4 && !$item["AllowRanked"]) { ?>
                          <h3 class="ban-text">BANNED IN RANKED</h3>
                      <?php } ?>
                    <p class="card-text">
                        <?php
                            if($item["Type"] == 1) {
                                echo "Champion";
                            } else if($item["Type"] == 2) {
                                echo "Relic";
                            } else if($item["Type"] == 3) {
                                echo "Spell";
                            } else if($item["Type"] == 4) {
                                echo "Equipment";
                            } else if($item["Type"] == 5) {
                                echo "Condition";
                            } else if($item["Type"] == 6) {
                                echo "Mechanic";
                            } else if($item["Type"] == 7) {
                                echo "Ability";
                            }
                        ?> ● <?php if($item["Type"] >= 1 && $item["Type"] <= 4) {
                            echo $item["NoraCost"]. " nora ● " . $item["Faction"] . " ● " . $item["Rarity"] . "";
                            if($item["Type"] <= 2) { 
                                if($item["Size"] == "1x1") { echo " ● Small"; } else { echo " ● Large"; } 
                            }
                        } else if($item["Type"] == 7) {
                            echo "worth " . $item["NoraCost"]. " nora";
                            if($item["Cooldown"] != 0) {
                                echo " ● Cooldown " . $item["Cooldown"];
                            }
                            if($item["Level"] != 0) {
                                echo " ● Rank " . $item["Level"];
                            }
                        } ?>
                    </p>
                    <div class="stats">
                        <?php if($item["Type"] == 1) { ?>
                            <div class="damage"><?php echo $item["Damage"] ?></div>
                            <div class="speed"><?php echo $item["Speed"] ?></div>
                            <div class="minrng"><?php echo $item["MinRng"] ?></div><div class="maxrng"><?php echo $item["MaxRng"] ?></div>
                        <?php }
                        if($item["Type"] == 1 || $item["Type"] == 2) { ?>
                            <div class="defense"><?php echo $item["Defense"] ?></div>
                            <div class="health"><?php echo $item["HitPoints"] ?></div>
                        <?php } ?>
                    </div>
                    <?php if($item["Type"] == 1) { ?>
                    <div class="body-set row">
                        <div class="base col-sm-4">
                            <span>Base</span>
                            <ul>
                            <?php foreach($item["StartingAbilities"] as $baseAbility) { ?>
                                <a href="/rune.php?id=<?php echo $baseAbility["ID"]; ?>&type=7"><li class="ability"><?php echo $baseAbility["Name"] ?></li></a>
                            <?php } ?>
                            </ul>
                        </div>
                        <div class="upgrade-1 col-sm-4">
                            <span>Upgrade line 1</span>
                            <ul>
                            <?php foreach($item["AbilitySet"][1] as $anUpgrade) { ?>
                                <a href="/rune.php?id=<?php echo $anUpgrade["ID"]; ?>&type=7"><li class="ability"><?php echo $anUpgrade["Name"]; if($anUpgrade["Default"]) { echo " (Default)"; } ?></li></a>
                            <?php } ?>
                            </ul>
                        </div>
                        <div class="upgrade-2 col-sm-4">
                            <span>Upgrade line 2</span>
                            <ul>
                            <?php foreach($item["AbilitySet"][2] as $anUpgrade) { ?>
                               <a href="/rune.php?id=<?php echo $anUpgrade["ID"]; ?>&type=7"> <li class="ability"><?php echo $anUpgrade["Name"]; if($anUpgrade["Default"]) { echo " (Default)"; } ?></li></a>
                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <?php } else { ?>
                        <div class="body-set">
                            <?php echo $item["Description"]; ?>
                        </div>
                    <?php } ?>
                    <div class="extras">
                        <?php if($item["Type"] == 1) { ?>
                            <div class="flavor"><?php echo $item["Description"]; ?></div>
                        <?php } else if($item["Type"] >= 2 && $item["Type"] <= 4) { ?>
                            <div class="flavor"><?php echo $item["FlavorText"]; ?></div>
                        <?php }
                        if($item["Type"] >= 1 && $item["Type"] <= 4) { ?>
                        <div class="rune-set"><?php echo $item["RuneSet"]; ?></div>
                        <?php if($item["Type"] == 1) { ?>
                            <div class='race'>Race: <?php
                                foreach (explode(" ", $item["Race"]) as $value) { ?>
                                    <a href='/search.php?search=race:"<?php echo $value; ?>"'><?php echo $value; ?></a>
                                <?php }
                            ?> </div>
                            <div class='class'>Class: <?php
                                foreach (explode(" ", $item["Class"]) as $value) { ?>
                                    <a href='/search.php?search=class:"<?php echo $value; ?>"'><?php echo $value; ?></a>
                                <?php }
                            ?> </div>
                        <?php } ?>
                        <div class="artist"><?php echo $item["Artist"]; ?></div>
                        <div class="status">
                            <?php if($item["ForSale"]) {
                                echo "Sellable ● ";
                            } else { 
                                echo "Unsellable ● ";
                            }
                            if($item["Tradeable"]) {
                                echo "Tradeable ● ";
                            } else {
                                echo "Untradeable ● ";
                            }
                            echo "Limit " . $item["DeckLimit"] . " in deck";
                            ?>
                        </div>
                        <div class="hide">Hash: <?php echo $item["Hash"]; ?></div>
                        <div class="hide">ID: <?php echo $item["ID"]; ?></div>
                        <?php } ?>
                    </div>
                  </div>
                </div>
                <?php if($item["Type"] == 7) { ?>
                    <a class="btn btn-primary" style="margin-top: 10px" href="/search.php?search=<?php echo htmlspecialchars("ability:\"".$item["OriginalName"]."\""); ?>">Find Champions with this ability.</a>
                <?php } else if($item["Type"] >= 1 && $item["Type"] <= 4 && isset($item["Quantity"])) { ?>
                    <p>You own <?php echo $item["Quantity"]; ?> copies of this rune.</p>
                <?php } ?>
            </div>
            <div id="side-info" class="info-group col-sm-6">
                <?php if($item["Type"] >= 1 && $item["Type"] <= 4) { ?>
                    <img class="img-full" src="https://d2aao99y1mip6n.cloudfront.net/images/runes/med/<?php echo $item['Hash']; ?>.jpg" />
                <?php } ?>
            </div>
        </div>
    </div>
    
        <?php require_once('./js/corejs.php'); ?>
    </body>
</html>
