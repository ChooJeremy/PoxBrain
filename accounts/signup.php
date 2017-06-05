<?php
	require_once('../mysqlaccess.php');

	try {
		//don't bother with email registration, just give them a user account
		$userId = $auth->register($_POST["email"], $_POST["password"], $_POST["username"], function($selector, $token)  use ($sendGridAPIKey) {
			$url = 'https://poxbrain.jch.ooo/verify_email?selector='.urlencode($selector).'&token='.urlencode($token);

			$from = new SendGrid\Email("no-reply", "no-reply@pox.jch.ooo");
			$subject = "PoxBrain Email Verification";
			$to = new SendGrid\Email($_POST["username"], $_POST["email"]);
			$textContent = new SendGrid\Content("text/plain", "Hi ".$_POST["username"].", \n\nYour account has been created. Please verify that you own this email address by clicking the following link: ".$url."\n\nIf you did not request this email, you can safely ignore it.\n\nNote: This email is sent from an unmonitored inbox. Replies are not tracked. If you wish to reply, feel free to post a message on the PoxBrain poxnora thead located at: http://forums.poxnora.com/index.php?threads/poxbrain-beta.26292/");
			$mail = new SendGrid\Mail($from, $subject, $to, $textContent);
			$htmlContent = new SendGrid\Content("text/html", '<!DOCTYPE html><head><title>PoxBrain Account Verification</title></head><body><table style="min-width: 200px; max-width: 500px; width: 60%; margin: 0 auto;"><tr><th style="background-color: black; margin: 0; padding: 10px; color: #9d9d9d; font-size: 20px; text-align: left;">PoxBrain</th></tr><tr><td><h4>Hi '.$_POST["username"].',</h4><p>    Your account has been created. Please verify that you own this email address by clicking the following link: <a href="'.$url.'">'.$url.'</a></p><p>If you did not request this email, you can safely ignore it.</p><p>Note: This email is sent from an unmonitored inbox. Replies are not tracked. If you wish to reply, feel free to post a message on the PoxBrain poxnora thead located at: <a href="http://forums.poxnora.com/index.php?threads/poxbrain-beta.26292/">http://forums.poxnora.com/index.php?threads/poxbrain-beta.26292/</a></p></td></tr></table></body></html>');
			$mail->addContent($htmlContent);
			$sg = new \SendGrid($sendGridAPIKey);
			$response = $sg->client->mail()->send()->post($mail);
			if($response->statusCode() !== 202) {
				echo "An error occured! Details: ";
				print_r($response->headers());
				die();
			}
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