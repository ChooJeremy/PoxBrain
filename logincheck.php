<?php
    require 'vendor/vendor/autoload.php';
    require 'mysqlaccess.php';
    
    $authDB = new PDO('mysql:dbname='.$userdb.';host='.$host.';port='.$port.';charset=utf8mb4', $user, $pass);
    $auth = new \Delight\Auth\Auth($authDB);

    if ($auth->isLoggedIn()) {
    // user is signed in
    echo "You are signed in. Your id is: ";
    echo $auth->getUserId();
    }
    else {
        // user is *not* signed in yet
        echo "You are not signed in";
    }
