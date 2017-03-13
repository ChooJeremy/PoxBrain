<?php
    require_once('../mysqlaccess.php');
    if ($_POST['remember'] == 1) {
        // keep logged in for one month
        $rememberDuration = (int) (60 * 60 * 24 * 30);
    }
    else {
        // do not keep logged in after session ends
        $rememberDuration = null;
    }

    
    try {
        $auth->login($_POST['email'], $_POST['password'], $rememberDuration);
        // user is logged in
        echo "OK";
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        // wrong email address
        echo "Wrong Email, please try again";
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        // wrong password
        echo "Wrong Password, please try again";
    }
    catch (\Delight\Auth\EmailNotVerifiedException $e) {
        // email not verified
        echo "Email not verified, please check your email and follow the link there";
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        // too many requests
        echo "You made too many requests in a short period of time. Please wait a while and try again.";
    }