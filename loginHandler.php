<?php
require('inc/db.php');

if(isset($_POST['submit'])) {
		$username = $c->escape_string(strtolower($_POST['username']));
		$password = $c->escape_string($_POST['password']);
		
		$query = $c->query("SELECT * FROM users WHERE username='$username'");

		if(empty($username) OR empty($password)) {
			$_SESSION['flash_msg'] = "All fields are mandatory.";
			header('Location: signin.php');
		}
		elseif($query->num_rows == 1) {
			$row = (object) $query->fetch_assoc();
			if(password_verify($password, $row->password)) {
				$_SESSION['username'] = $username;
				header('Location: index.php');
			}
			else {
				$_SESSION['flash_msg'] = "Password do not match for the given username.";
				header('Location: signin.php');
			}
		}
		else {
			$_SESSION['flash_msg'] = "Username and Password do not match.";
			header('Location: signin.php');
		}
	}

	else {
			header('Location: login.php');
	}
