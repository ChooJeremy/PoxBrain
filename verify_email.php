<?php
require_once('./mysqlaccess.php');
try {
    $auth->confirmEmail($_GET['selector'], $_GET['token']);

    // email address has been verified
}
catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    // invalid token
    echo "Invalid Token. Please ensure that the link you followed is complete.";
}
catch (\Delight\Auth\TokenExpiredException $e) {
    // token expired
    echo "Token Expired. ";
}
catch (\Delight\Auth\TooManyRequestsException $e) {
    // too many requests
    echo "Too Many Requests have been made from this IP. Please try again later.";
}