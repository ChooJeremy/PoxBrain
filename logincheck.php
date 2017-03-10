<?php
    require_once('./mysqlaccess.php');    
    
    if ($auth->isLoggedIn()) {
    // user is signed in
    echo "You are signed in. Your id is: ";
    echo $auth->getUserId();
    }
    else {
        // user is *not* signed in yet
        echo "You are not signed in";
    }
