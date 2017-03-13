<?php
    require_once('./mysqlaccess.php');

    try {
        //don't bother with email registration, just give them a user account
        $userId = $auth->register($_POST["email"], $_POST["password"], $_POST["username"], function($selector, $token) {
            $url = 'https://poxbrain.jch.ooo/verify_email?selector='.urlencode($selector).'&token='.urlencode($token);
            $headers = 'From: no-reply@poxbrain.jch.ooo' . "\r\n" .
                'Reply-To: no-reply@poxbrain.jch.ooo' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            mail($_POST["email"], "PoxBrain Email Verification", "Hi " .$POST["username"].", \n\nYour account has been created. Please verify that you own this email address by clicking the following link: ".$url."\nIf the link doesn't work, try copying the text and pasting it into the URL bar.\n\nBy verifying your account, you'll be able to use more features of the site, like collection tracking.\n\nHave fun!\n\nNote: This email is sent from an unmonitored inbox. Replies are not tracked. If you wish to reply, feel free to post a message on the PoxBrain poxnora thead located at: http://forums.poxnora.com/index.php?threads/poxbrain-beta.26292/", $headers);
        });
        // we have signed up a new user with the ID `$userId`
        //$auth->login($_POST['email'], $_POST['password']);
        
        //create a new row in the userdata table
        $shards = 0;
        //Update shards on the user's accounts
        if (!($userAdd = $mysqli->prepare("INSERT INTO UserData VALUES (?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
        }
        
        if (!$userAdd->bind_param("ii", $userId, $shards)) {
            echo "Binding parameters failed: (" . $userAdd->errno . ") " . $userAdd->error; die();
        }
        
        if (!$userAdd->execute()) {
            echo "Execute failed: (" . $userAdd->errno . ") " . $userAdd->error;  die();
        }
        $userAdd->close();

        echo "OK";
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        // invalid email address
        echo "Invalid email address";
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        // invalid password
        echo "Invalid password";
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        // user already exists
        echo "User already exists";
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        // too many requests
        echo "Too many requests";
    }
    catch (\Delight\Auth\DatabaseError $e) {
        echo "Database Error with this account. Try a different one.";
        error_log($e);
    }
?>