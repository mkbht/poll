<?php
	require_once('inc/db.php');

	if(isset($_POST['submit'])) {
		$username 	= strtolower($_POST['username']);
		$password 	= $_POST['password'];
		$first_name	= $_POST['first_name'];
		$last_name 	= $_POST['last_name'];
		$email 		= $_POST['email'];
		$gender 	= $_POST['gender'];
		$country 	= $_POST['country'];


		$username_exists = $c->query("SELECT * FROM users WHERE username='{$c->escape_string($username)}'");
		$email_exists = $c->query("SELECT * FROM users WHERE email='{$c->escape_string($email)}'");

		if(empty($username) OR empty($password) OR empty($first_name) OR empty($last_name) OR empty($email) OR empty($gender) OR empty($country)) {
			$_SESSION['flash_msg'] = "All fields are mandatory.";
			header('Location: signup.php');
		}
		elseif(strlen($username) < 6 ) {
			$_SESSION['flash_msg'] = "Username must be at least 6 characters long.";
			header('Location: signup.php');
		}
		elseif(!preg_match('/^[a-z][a-z0-9\_\-]+$/', $username)) {
			$_SESSION['flash_msg'] = "Username must start with alphabet and can consist alphanumeric characters , dashes(-) and underscores(_).";
			header('Location: signup.php');
		}
		elseif($username_exists->num_rows > 0) {
			$_SESSION['flash_msg'] = "Username already exists. Please select another username.";
			header('Location: signup.php');
		}
		elseif($email_exists->num_rows > 0) {
			$_SESSION['flash_msg'] = "Email Address already in use.";
			header('Location: signup.php');
		}
		else {
			$query = $c->prepare("INSERT INTO users (username, password, first_name, last_name, email, gender, country) VALUES (?,?,?,?,?,?,?)");
			$query->bind_param('sssssss', $username, $password_hash, $first_name, $last_name, $email, $gender, $country);
			$password_hash = password_hash($password, PASSWORD_DEFAULT);
			$query->execute();
			$_SESSION['username'] = $username;
			header('Location: index.php');
			}
		}

	}