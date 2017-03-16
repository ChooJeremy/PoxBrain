<?php 
    require_once('../mysqlaccess.php');
    if(!$auth->isLoggedIn()) {
        echo "You are not logged in. Please log in before you attempt to change your password.";
        die();
    }
    try {
        $auth->changePassword($_POST['oldPassword'], $_POST['newPassword']);
    
        // password has been changed
        echo "OK";
    }
    catch (\Delight\Auth\NotLoggedInException $e) {
        // not logged in
        echo "You are not logged in. Please log in before you attempt to change your password.";
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        // invalid password(s)
        echo "Invalid Password";
    }
