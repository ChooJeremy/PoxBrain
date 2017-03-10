<?php
    require_once('./mysqlaccess.php');

    try {
        //don't bother with email registration, just give them a user account
        $userId = $auth->register($_POST["email"], $_POST["password"], $_POST["username"]);
        
        $auth->login($_POST['email'], $_POST['password']);
        // we have signed up a new user with the ID `$userId`
        
        //create a new row in the userdata table
        $shards = 0;
        //Update shards on the user's accounts
        if (!($userAdd = $mysqli->prepare("INSERT INTO UserData VALUES (?, ?)"))) {
            echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; die();
        }
        
        if (!$userAdd->bind_param("ii", $shards, $userID)) {
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
        var_dump($e);
    }
?>