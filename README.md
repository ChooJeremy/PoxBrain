# PoxBrain



PoxBrain is a database to aid users through the complex game of [PoxNora](http://www.poxnora.com)!
There have been many other sites like this created, such as PoxPulse and PoxBase, but they all haven't been updated for quite a while and have lost active support, so PoxBrain aims to be the new PoxNora aid.
You can find this website live at [https://poxbrain.jch.ooo](https://poxbrain.jch.ooo)
Note that the website isn't always updated to the latest commit in this repo.

Design inspired by [NetrunnerDB](https://netrunnerdb.com)

## Features

* A page that shows details about a rune, ability, mechanic or condition
* Search suggestions as you type on the search bar. Potential search suggestions are loaded locally.
* Ability to search for runes, sorted by relevancy to search results.
* Filter search results by rarity, faction and rune Type
* Accounts for users.
  * Users are able to track their collection on PoxNora in PoxBrain
  * Display owned amount of search suggestions and results


## Planned Features

In no particular order,
* Work with PoxBox to display rune price on PoxBox
* Accounts for users.
  * Collection statistics for themselves
  * Anonymous aggregated statistics
  * JS code to 'shard' runes that are extras, with certain criterias
  * Show runes that are worth 'sharding' based on PoxBox price. Show other runes that are best sent to PoxBox instead.
  * Other ways to browse their collection than the editor in PoxNora
* BattleGroups creation and sharing
  * Writeups like NetrunnerDB for their own BG
  * Linking with collection to show which rune you own and don't
  * JS code to create a new BG on PoxNora based on the BG shown in PoxBrain
* Achievement Helper
  * Enter achievement conditions and find runes that fit that criteria
  * Link with user accounts to only show runes that the user owns

## Contributing

Download the repo. You'll need a server, we currently use a LAMP stack. You'll have to initalize the database with the required tables. The SQL code required to generate these tables (imported from phpmyadmin) can be found at [dbinit.sql](./dbinit.sql)
You'll also need to specify how to connect to the sql database. Currently the codes use mysqli to connect. You'll have to create a mysqlaccess.php file in the root folder, with the following structure:

```php
<?php
$host = "127.0.0.1";
$user = "username";
$pass = "mypassword";
$db = "dbname";
$port = 80;

$userdb = "user_accounts";
$mysqli = mysqli_connect($host, $user, $pass, $db, $port)or die(mysql_error());

require 'vendor/vendor/autoload.php';

$authDB = new PDO('mysql:dbname='.$userdb.';host='.$host.';port='.$port.';charset=utf8mb4', $user, $pass);
$auth = new \Delight\Auth\Auth($authDB);
?>
```

This will allow all the codes to use your database.
Once you've started the database, you'll need to update it. Simply run update.php (preferably from the command line, so you get the echo'ed messages as they come) to populate the database with the necessary information. You may receive a message saying something like `$_SERVER["REMOTE_ADDR"] is not defined`, ignore it, it's basically saying it can't find the other party's IP address (normal as you're running from the own machine).
Once done, the website should run normally. PHP Auth is inside the repo already, located under ./vendor/vendor/delight-im

Note: this repo contains a .htaccess so that it can be installed directly into the server www/ directory. If installed correctly with .htaccess files enabled, it will return 404 on attempts to access files that do not pertain to the site.

