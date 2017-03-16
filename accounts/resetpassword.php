<?php
    require_once('../mysqlaccess.php');
    if(isset($_POST["selector"], $_POST["token"], $_POST["password"])) {
        try {
            $auth->resetPassword($_POST['selector'], $_POST['token'], $_POST['password']);
        
            // password has been reset
            echo "OK";
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            // invalid token
            echo "Invalid token. Try another <a href='/forgetpassword.php'>password reset request.</a>";
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            // token expired
            echo "Your token has expired. Try another  <a href='/forgetpassword.php'>password reset request.</a>.";
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            // invalid password
            echo "Invalid password";
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            // too many requests
            echo "Too many requests";
        }
        die();
    }
    try {
        $auth->forgotPassword($_POST['email'], function ($selector, $token) {
            // send `$selector` and `$token` to the user (e.g. via email)
            $url = 'https://poxbrain.jch.ooo/forgetpassword.php?selector='.urlencode($selector).'&token='.urlencode($token);
            $headers = 'From: no-reply@poxbrain.jch.ooo' . "\r\n" .
                'Reply-To: no-reply@poxbrain.jch.ooo' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            mail($_POST["email"], "PoxBrain Password Reset Request", "Someone entered in this email as a request to reset the password of this account. If this was you, click here to reset your password: ".$url."\n\nIf you did not request this email, you can safely ignore it.\n\nNote: This email is sent from an unmonitored inbox. Replies are not tracked. If you wish to reply, feel free to post a message on the PoxBrain poxnora thead located at: http://forums.poxnora.com/index.php?threads/poxbrain-beta.26292/", $headers);    
        });
    
        // request has been generated
        echo "OK";
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        // invalid email address
        echo "No such email address was found in the system";
    }
    catch (\Delight\Auth\EmailNotVerifiedException $e) {
        // email not verified
        echo "Email wasn't verified. Try <a href='email_confirmation.php'>resending the confirmation email</a>.";
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        // too many requests
        echo "Too many requests. Try again later.";
    }
