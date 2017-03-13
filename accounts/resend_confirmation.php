<?php
require_once('../mysqlaccess.php');

if(isset($_GET["email"])) {
    $auth->createConfirmationRequest($_GET["email"], function($selector, $token) {
        $url = 'https://poxbrain.jch.ooo/verify_email?selector='.urlencode($selector).'&token='.urlencode($token);
        $headers = 'From: no-reply@poxbrain.jch.ooo' . "\r\n" .
            'Reply-To: no-reply@poxbrain.jch.ooo' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($_POST["email"], "PoxBrain Email Verification", "Hi " .$POST["username"].", \n\nYour account has been created. Please verify that you own this email address by clicking the following link: ".$url."\nIf the link doesn't work, try copying the text and pasting it into the URL bar.\n\nBy verifying your account, you'll be able to use more features of the site, like collection tracking.\n\nHave fun!\n\nNote: This email is sent from an unmonitored inbox. Replies are not tracked. If you wish to reply, feel free to post a message on the PoxBrain poxnora thead located at: http://forums.poxnora.com/index.php?threads/poxbrain-beta.26292/", $headers);
    });
    echo "OK";
} else {
    echo "No Email";
}